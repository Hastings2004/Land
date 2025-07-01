<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index(){
        $user = auth()->user();
        $stats = null;
        if ($user && $user->isAdmin()) {
            $stats = [
                'totalPlots' => \App\Models\Plot::count(),
                'totalUsers' => \App\Models\User::count(),
                'totalReservations' => \App\Models\Reservation::count(),
                'totalInquiries' => \App\Models\Inquiries::count(),
                'totalReviews' => \App\Models\Review::count(),
                'totalRevenue' => \App\Models\Payment::sum('amount'), // Assumes 'amount' column exists
            ];

            // Revenue per month for the last 12 months
            $revenueData = \App\Models\Payment::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(amount) as total')
                ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
                ->groupBy('month')
                ->orderBy('month')
                ->get();
            $months = [];
            $totals = [];
            $period = \Carbon\CarbonPeriod::create(now()->subMonths(11)->startOfMonth(), '1 month', now()->startOfMonth());
            foreach ($period as $date) {
                $month = $date->format('Y-m');
                $months[] = $date->format('M Y');
                $found = $revenueData->firstWhere('month', $month);
                $totals[] = $found ? (float)$found->total : 0;
            }

            // Plot category distribution
            $categoryData = \App\Models\Plot::selectRaw('category, COUNT(*) as count')
                ->groupBy('category')
                ->get();
            $categoryLabels = $categoryData->pluck('category')->toArray();
            $categoryCounts = $categoryData->pluck('count')->toArray();

            // Scatter plot data: price vs area
            $scatterData = \App\Models\Plot::select('area_sqm', 'price')->get()->map(function($plot) {
                return [
                    'x' => (float)$plot->area_sqm,
                    'y' => (float)$plot->price
                ];
            });

            // New plots added per month (last 12 months)
            $plotsData = \App\Models\Plot::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
                ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
                ->groupBy('month')
                ->orderBy('month')
                ->get();
            $plotsMonths = [];
            $plotsCounts = [];
            $plotsPeriod = \Carbon\CarbonPeriod::create(now()->subMonths(11)->startOfMonth(), '1 month', now()->startOfMonth());
            foreach ($plotsPeriod as $date) {
                $month = $date->format('Y-m');
                $plotsMonths[] = $date->format('M Y');
                $found = $plotsData->firstWhere('month', $month);
                $plotsCounts[] = $found ? (int)$found->count : 0;
            }

            // Inquiries received per month (last 12 months)
            $inquiriesData = \App\Models\Inquiries::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
                ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
                ->groupBy('month')
                ->orderBy('month')
                ->get();
            $inquiriesMonths = [];
            $inquiriesCounts = [];
            $inquiriesPeriod = \Carbon\CarbonPeriod::create(now()->subMonths(11)->startOfMonth(), '1 month', now()->startOfMonth());
            foreach ($inquiriesPeriod as $date) {
                $month = $date->format('Y-m');
                $inquiriesMonths[] = $date->format('M Y');
                $found = $inquiriesData->firstWhere('month', $month);
                $inquiriesCounts[] = $found ? (int)$found->count : 0;
            }

            // Top 5 viewed plots (assumes 'views' column exists)
            $topViewed = \App\Models\Plot::orderByDesc('views')->take(5)->get(['title', 'views']);
            $topViewedLabels = $topViewed->pluck('title')->toArray();
            $topViewedCounts = $topViewed->pluck('views')->toArray();
        }
        return view('dashboard', compact('stats', 'months', 'totals', 'categoryLabels', 'categoryCounts', 'scatterData', 'plotsMonths', 'plotsCounts', 'inquiriesMonths', 'inquiriesCounts', 'topViewedLabels', 'topViewedCounts'));
    }
}
