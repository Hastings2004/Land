<?php

namespace App\Http\Controllers;

use App\Models\Plot;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerPlotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       $query = Plot::query();

        // Search
        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%")
                  ->orWhere('location', 'like', "%{$request->search}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Location filter
        if ($request->filled('location')) {
            $query->where('location', $request->location);
        }

        // Price range filter
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        // Area range filter
        if ($request->filled('area_min')) {
            $query->where('area_sqm', '>=', $request->area_min);
        }
        if ($request->filled('area_max')) {
            $query->where('area_sqm', '<=', $request->area_max);
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // New listings filter
        if ($request->has('new_listings')) {
            $query->where('is_new_listing', true);
        }

        $plots = $query->latest()->paginate(9)->appends($request->except('page'));

        // For dropdowns
        $categories = ['residential', 'commercial', 'industrial'];
        $locations = Plot::select('location')->distinct()->pluck('location');
        $statuses = ['available', 'reserved', 'sold'];

        return view('customer.plots.index', compact('plots', 'categories', 'locations', 'statuses'));
    }
    /**
     * Display the specified resource.
     */ 
    public function show(Plot $plot)
    {
        if ($plot->status === 'sold' && optional($plot->activeReservation)->user_id !== Auth::id()) {
            abort(404, 'Land plot not found or not available.');
        }

        return view('customer.plots.show', compact('plot'));
    }

}
