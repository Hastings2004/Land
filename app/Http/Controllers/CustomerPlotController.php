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
       $query = Plot::where('status', 'available')->latest();

        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%")
                  ->orWhere('location', 'like', "%{$request->search}%");
            });
        }

        if ($request->has('new_listings')) {
            $query->where('is_new_listing', true);
        }

        $plots = $query->paginate(9);

        return view('customer.plots.index', compact('plots'));

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
