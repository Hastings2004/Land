<?php

namespace App\Http\Controllers;

use App\Models\Plot;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPlotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // If there are search parameters, redirect to search
        if (request()->hasAny(['title', 'description', 'location', 'price', 'availability'])) {
            return $this->search(request());
        }
        // Fetch plots with pagination, ordered by the latest
        $plots = Plot::latest()->paginate(10);
       
        return view('admin.plots.index', ["plots" => $plots]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Simply return the view for creating a new plot
        return view('admin.plots.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Check if the user is an admin
        if ($user->role !== "admin") {
            // Redirect or abort if not an admin. Returning a view might not be appropriate
            // for an unauthorized action on a POST request.
            abort(403, 'Unauthorized action.'); // Recommended for API/form submissions
            // Alternatively, redirect to an appropriate page:
            // return redirect()->route('admin.dashboard')->with('error', 'You are not authorized to perform this action.');
        }

        // Validate the incoming request, including the image
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'area_sqm' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
            'is_new_listing' => 'boolean', 
        ]);

        $imagePath = null;
        // Handle image upload
        if ($request->hasFile('image')) {
            // The 'public' disk is configured in config/filesystems.php
            $imagePath = $request->file('image')->store('plots', 'public');
        }

       
        //$validatedData['is_new_listing'] = $request->has('is_new_listing');


        // Add the image path to the validated data before creating the plot
        $validatedData['image_path'] = $imagePath; // Make sure your 'plots' table has an 'image_path' column

        // Create the plot using the validated data
        Plot::create($validatedData);

        // Redirect with a success message
        return redirect()->route('plots.index')
            ->with('success', 'Plot created successfully.');
    }
    /**
     * Display the specified resource.
     */
    public function show(Plot $plot)
    {
        $activeView = 'admin_plots_show'; // For sidebar highlighting, etc.

        return view('admin.plots.show', compact('plot', 'activeView'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Plot $plot)
    {
        $activeView = 'admin_plots_edit'; 

        return view('admin.plots.edit', compact('plot', 'activeView'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Plot $plot)
    {
        
        
        $user = Auth::user();

        if($user->role != "admin"){
            return view("admin.plots.index");
        }        
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'area_sqm' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'category' => 'required|in:residential,commercial,industrial',
        ]);
        // Update the plot with the validated data
        $plot->update($validated);

        // Redirect with a success message
        return redirect()->route('plots.index')
            ->with('success', 'Plot updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plot $plot)
    {
        // Delete the plot
        $plot->delete();

        // Redirect with a success message
        return redirect()->route('plots.index')
            ->with('success', 'Plot deleted successfully.');
    }

    /**
     * Search plots by title, description, location, price, and availability.
     */
    public function search(Request $request)
    {
        $query = Plot::query();

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->input('title') . '%');
        }
        if ($request->filled('description')) {
            $query->where('description', 'like', '%' . $request->input('description') . '%');
        }
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->input('location') . '%');
        }
        if ($request->filled('price')) {
            $query->where('price', $request->input('price'));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $plots = $query->latest()->paginate(10)->appends($request->except('page'));

        return view('admin.plots.index', ["plots" => $plots]);
    }
}