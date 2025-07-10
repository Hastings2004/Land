<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Plot;
use App\Models\Reservation;
use App\Models\Inquiries;
use App\Models\Review;
use App\Models\Payment;

class DashboardController extends Controller
{
    //
    /**
     * Main dashboard route - redirects based on user role
     */
    public function index()
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('customer.dashboard');
        }
    }

    /**
     * Admin dashboard with comprehensive statistics
     */
    public function adminDashboard()
    {
            $stats = [
                'totalPlots' => \App\Models\Plot::count(),
                'totalUsers' => \App\Models\User::count(),
                'totalReservations' => \App\Models\Reservation::count(),
                'totalInquiries' => \App\Models\Inquiries::count(),
                'newInquiries' => \App\Models\Inquiries::where('status', 'new')->count(),
                'totalReviews' => \App\Models\Review::count(),
            ];

            // Plot status distribution
            $statusData = \App\Models\Plot::selectRaw('status, COUNT(*) as count')
                ->groupBy('status')
                ->get();
            $statusLabels = $statusData->pluck('status')->toArray();
            $statusCounts = $statusData->pluck('count')->toArray();
            if (empty($statusLabels)) {
                $statusLabels = ['No Data'];
                $statusCounts = [1];
            }

            // Inquiry status distribution
            $inquiryStatusData = \App\Models\Inquiries::selectRaw('status, COUNT(*) as count')
                ->groupBy('status')
                ->get();
            $inquiryStatusLabels = $inquiryStatusData->pluck('status')->toArray();
            $inquiryStatusCounts = $inquiryStatusData->pluck('count')->toArray();
            if (empty($inquiryStatusLabels)) {
                $inquiryStatusLabels = ['No Data'];
                $inquiryStatusCounts = [1];
            }

            // Reservations status distribution
            $reservationsData = \App\Models\Reservation::selectRaw('status, COUNT(*) as count')
                ->groupBy('status')
                ->get();
            $reservationsLabels = $reservationsData->pluck('status')->toArray();
            $reservationsCounts = $reservationsData->pluck('count')->toArray();
            if (empty($reservationsLabels)) {
                $reservationsLabels = ['No Data'];
                $reservationsCounts = [1];
            }

        // Most viewed plots (top 5)
        $mostViewedPlots = \App\Models\Plot::orderByDesc('views')->take(5)->get();

        // Plots with most reservations (top 5)
        $plotsMostReservations = \App\Models\Plot::withCount('reservations')
            ->orderByDesc('reservations_count')
            ->take(5)
            ->get();

        // Average time to sale (in days)
        $soldPlots = \App\Models\Plot::where('status', 'sold')->whereNotNull('created_at')->whereNotNull('updated_at')->get();
        $avgTimeToSale = $soldPlots->count() > 0
            ? round($soldPlots->map(function($plot) { return $plot->updated_at->diffInDays($plot->created_at); })->avg(), 2)
            : null;

        // Recent sales (last 5 sold plots)
        $recentSales = \App\Models\Plot::where('status', 'sold')->latest('updated_at')->take(5)->get();

        // Recent inquiries for admin dashboard
        $recentInquiries = \App\Models\Inquiries::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'stats', 'statusLabels', 'statusCounts',
            'inquiryStatusLabels', 'inquiryStatusCounts', 
            'reservationsLabels', 'reservationsCounts', 'recentInquiries',
            'mostViewedPlots', 'plotsMostReservations', 'avgTimeToSale', 'recentSales'
        ));
    }

    /**
     * Customer dashboard with personal statistics
     */
    public function customerDashboard()
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        $stats = [
            'savedPlots' => $user->savedPlots()->count(),
            'reservations' => $user->reservations()->count(),
            'inquiries' => \App\Models\Inquiries::where('email', $user->email)->count(),
            'reviews' => $user->reviews()->count(),
        ];

        // Recent saved plots
        $recentSavedPlots = $user->savedPlots()->latest()->take(5)->get();

        // Active reservations
        $activeReservations = $user->reservations()->where('status', 'active')->latest()->take(5)->get();

        // Recent inquiries
        $recentInquiries = \App\Models\Inquiries::where('email', $user->email)->latest()->take(5)->get();

        // Recommended plots based on user preferences and market trends
        $recommendedPlots = $this->getRecommendedPlots($user);

        // Market insights data
        $marketInsights = $this->getMarketInsights();

        // Recent activity for the user
        $recentActivity = $this->getRecentActivity($user);

        return view('customer.dashboard', compact(
            'stats', 'recentSavedPlots', 'activeReservations', 'recentInquiries',
            'recommendedPlots', 'marketInsights', 'recentActivity'
        ));
    }

    /**
     * Get recommended plots for the user
     */
    private function getRecommendedPlots($user)
    {
        // Get IDs of plots the user has reserved or saved
        $reservedPlotIds = $user->reservations()->pluck('plot_id')->toArray();
        $savedPlotIds = $user->savedPlots()->pluck('plots.id')->toArray();
        $excludeIds = array_unique(array_merge($reservedPlotIds, $savedPlotIds));

        // Get locations and price range from user's saved/reserved plots
        $userPlots = \App\Models\Plot::whereIn('id', $excludeIds)->get();
        $locations = $userPlots->pluck('location')->unique()->toArray();
        $minPrice = $userPlots->min('price') ?? 0;
        $maxPrice = $userPlots->max('price') ?? 0;

        // Recommend available plots in similar locations or price range, not already reserved/saved
        $query = \App\Models\Plot::where('status', 'available')
            ->whereNotIn('id', $excludeIds);
        if (!empty($locations)) {
            $query->whereIn('location', $locations);
        }
        if ($minPrice && $maxPrice && $minPrice !== $maxPrice) {
            $query->whereBetween('price', [max(0, $minPrice - 500000), $maxPrice + 500000]);
        }
        // Fallback: if no user history, show latest available plots
        $plots = $query->orderBy('created_at', 'desc')->take(6)->get();
        if ($plots->isEmpty()) {
            $plots = \App\Models\Plot::where('status', 'available')
                ->whereNotIn('id', $excludeIds)
                ->orderBy('created_at', 'desc')
                ->take(6)
                ->get();
        }
        return $plots;
    }

    /**
     * Get market insights data
     */
    private function getMarketInsights()
    {
        // Calculate average price for plots uploaded by admins
        $averagePrice = \App\Models\Plot::where('status', 'available')
            ->whereHas('user', function($q) {
                $q->where('role', 'admin');
            })
            ->avg('price') ?? 0;

        // Get price change (compare current month vs last month) for admin plots
        $currentMonthAvg = \App\Models\Plot::where('status', 'available')
            ->whereHas('user', function($q) {
                $q->where('role', 'admin');
            })
            ->whereMonth('created_at', now()->month)
            ->avg('price') ?? 0;

        $lastMonthAvg = \App\Models\Plot::where('status', 'available')
            ->whereHas('user', function($q) {
                $q->where('role', 'admin');
            })
            ->whereMonth('created_at', now()->subMonth()->month)
            ->avg('price') ?? 0;

        $priceChange = $lastMonthAvg > 0 ? (($currentMonthAvg - $lastMonthAvg) / $lastMonthAvg) * 100 : 0;

        // Count new listings this week uploaded by admins
        $newListingsThisWeek = \App\Models\Plot::where('status', 'available')
            ->whereHas('user', function($q) {
                $q->where('role', 'admin');
            })
            ->where('created_at', '>=', now()->subWeek())
            ->count();

        $newListingsLastWeek = \App\Models\Plot::where('status', 'available')
            ->whereHas('user', function($q) {
                $q->where('role', 'admin');
            })
            ->whereBetween('created_at', [now()->subWeeks(2), now()->subWeek()])
            ->count();

        $newListingsChange = $newListingsLastWeek > 0 ? (($newListingsThisWeek - $newListingsLastWeek) / $newListingsLastWeek) * 100 : 0;

        // Calculate average days on market for admin plots
        $avgDaysOnMarket = \App\Models\Plot::where('status', 'available')
            ->whereHas('user', function($q) {
                $q->where('role', 'admin');
            })
            ->whereNotNull('created_at')
            ->get()
            ->avg(function($plot) {
                return $plot->created_at->diffInDays(now());
            }) ?? 0;

        $avgDaysOnMarketLastMonth = \App\Models\Plot::where('status', 'available')
            ->whereHas('user', function($q) {
                $q->where('role', 'admin');
            })
            ->whereNotNull('created_at')
            ->where('created_at', '<=', now()->subMonth())
            ->get()
            ->avg(function($plot) {
                return $plot->created_at->diffInDays(now()->subMonth());
            }) ?? 0;

        $daysOnMarketChange = $avgDaysOnMarketLastMonth > 0 ? (($avgDaysOnMarket - $avgDaysOnMarketLastMonth) / $avgDaysOnMarketLastMonth) * 100 : 0;

        return [
            'averagePrice' => number_format($averagePrice, 0),
            'priceChange' => round($priceChange, 1),
            'newListings' => $newListingsThisWeek,
            'newListingsChange' => round($newListingsChange, 1),
            'daysOnMarket' => round($avgDaysOnMarket),
            'daysOnMarketChange' => round($daysOnMarketChange, 1),
        ];
    }

    /**
     * Get recent activity for the user
     */
    private function getRecentActivity($user)
    {
        $activities = collect();

        // Recent saved plots
        $recentSaved = $user->savedPlots()->latest()->take(2)->get();
        foreach ($recentSaved as $plot) {
            $activities->push([
                'type' => 'saved_plot',
                'message' => 'Plot saved successfully',
                'time' => $plot->pivot->created_at ?? now(),
                'icon' => 'check',
                'color' => 'green'
            ]);
        }

        // Recent inquiries
        $recentInquiries = \App\Models\Inquiries::where('email', $user->email)
            ->latest()
            ->take(2)
            ->get();
        foreach ($recentInquiries as $inquiry) {
            $activities->push([
                'type' => 'inquiry',
                'message' => 'Inquiry sent to agent',
                'time' => $inquiry->created_at,
                'icon' => 'envelope',
                'color' => 'blue'
            ]);
        }

        // Recent reservations
        $recentReservations = $user->reservations()->latest()->take(2)->get();
        foreach ($recentReservations as $reservation) {
            $activities->push([
                'type' => 'reservation',
                'message' => 'Reservation confirmed',
                'time' => $reservation->created_at,
                'icon' => 'calendar',
                'color' => 'purple'
            ]);
        }

        // Sort by time and take the most recent 4
        return $activities->sortByDesc('time')->take(4);
    }
}
