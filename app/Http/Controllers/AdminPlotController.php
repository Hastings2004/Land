<?php

namespace App\Http\Controllers;

use App\Models\Plot;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Notifications\NewPlotNotification;
use App\Models\User;
use Illuminate\Support\Facades\Storage as FacadesStorage;
use Illuminate\Support\Facades\Log;

class AdminPlotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get sort parameter from request
        $sort = request('sort', 'latest');

        // Build query with plotImages relationship
        $query = Plot::with('plotImages');

        // Apply search if search parameter is provided
        if (request()->filled('search')) {
            $searchTerm = request('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%')
                  ->orWhere('location', 'like', '%' . $searchTerm . '%')
                  ->orWhere('category', 'like', '%' . $searchTerm . '%')
                  ->orWhere('price', 'like', '%' . $searchTerm . '%')
                  ->orWhere('area_sqm', 'like', '%' . $searchTerm . '%');
            });
        }

        // Only show available, reserved, or sold plots (never show sold as available)
        if (request()->filled('status')) {
            $query->where('status', request('status'));
        }

        if (request()->filled('category')) {
            $query->where('category', request('category'));
        }

        if (request()->filled('min_price')) {
            $query->where('price', '>=', request('min_price'));
        }

        if (request()->filled('max_price')) {
            $query->where('price', '<=', request('max_price'));
        }

        if (request()->filled('min_area')) {
            $query->where('area_sqm', '>=', request('min_area'));
        }

        if (request()->filled('max_area')) {
            $query->where('area_sqm', '<=', request('max_area'));
        }

        // Apply sorting based on parameter
        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'area_small':
                $query->orderBy('area_sqm', 'asc');
                break;
            case 'area_large':
                $query->orderBy('area_sqm', 'desc');
                break;
            case 'views':
                $query->orderBy('views', 'desc')->orderBy('created_at', 'desc');
                break;
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        // Apply new listings filter if requested
        if (request('new_listings')) {
            $query->where('is_new_listing', true);
        }

        // Fetch plots with pagination
        $plots = $query->paginate(10)->appends(request()->query());

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
        \Log::info('FILES:', ['files' => $request->file('images')]);
        $user = Auth::user();

        // Check if the user is an admin
        if ($user->role !== "admin") {
            // Redirect or abort if not an admin. Returning a view might not be appropriate
            // for an unauthorized action on a POST request.
            abort(403, 'Unauthorized action.'); // Recommended for API/form submissions
            // Alternatively, redirect to an appropriate page:
            // return redirect()->route('admin.dashboard')->with('error', 'You are not authorized to perform this action.');
        }

        // Validate the incoming request, including multiple images
        Log::info('AdminPlotController@store: Validating request', $request->all());
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'area_sqm' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'category' => 'required|string|in:residential,commercial,industrial',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:30720',
            'is_new_listing' => 'nullable',
        ]);
        Log::info('AdminPlotController@store: Validation passed', $validatedData);

        // Handle checkbox value
        $validatedData['is_new_listing'] = $request->has('is_new_listing');

        // Create the plot first
        $validatedData['user_id'] = $user->id;
        $plot = Plot::create($validatedData);
        Log::info('AdminPlotController@store: Plot created', ['plot_id' => $plot->id]);

        // Notify all customers about the new plot
        $customers = User::where('role', 'customer')->get();
        foreach ($customers as $customer) {
            $customer->notify(new NewPlotNotification($plot));
        }

        // Handle multiple image uploads
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            $sortOrder = 1;
            Log::info('AdminPlotController@store: Images found', ['count' => count($images)]);

            foreach ($images as $image) {
                if ($image->isValid()) {
                    $imagePath = $image->store('plots', 'public');
                    Log::info('AdminPlotController@store: Image stored', ['image_path' => $imagePath]);

                    // Create plot image record
                    $plotImage = $plot->plotImages()->create([
                        'plot_id' => $plot->id,
                        'image_path' => $imagePath,
                        'alt_text' => $plot->title . ' - Image ' . $sortOrder,
                        'sort_order' => $sortOrder,
                        'is_primary' => $sortOrder === 1, // First image is primary
                    ]);
                    Log::info('AdminPlotController@store: PlotImage created', ['plot_image_id' => $plotImage->id, 'plot_id' => $plot->id]);

                    $sortOrder++;
                } else {
                    Log::warning('AdminPlotController@store: Invalid image skipped');
                }
            }
        } else {
            Log::info('AdminPlotController@store: No images uploaded');
        }

        // Check if it's an AJAX request
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Plot created successfully! Your new property listing has been added to the system.',
                'redirect' => route('admin.plots.index')
            ]);
        }

        // Redirect with a success message for regular requests
        return redirect()->route('admin.plots.index');
    }
    /**
     * Display the specified resource.
     */
    public function show(Plot $plot)
    {
        $activeView = 'admin_plots_show'; // For sidebar highlighting, etc.

        // Load the relationships to prevent N+1 queries and null errors
        $plot->load(['inquiries', 'reviews.user', 'plotImages']);

        return view('admin.plots.show', compact('plot', 'activeView'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Plot $plot)
    {
        $activeView = 'admin_plots_edit';

        // Load plotImages relationship
        $plot->load('plotImages');

        return view('admin.plots.edit', compact('plot', 'activeView'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Plot $plot)
    {
        $user = Auth::user();

        if($user->role != "admin"){
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'area_sqm' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
            'existing_images' => 'array',
            'removed_images' => 'array',
        ]);

        // Handle the is_new_listing checkbox
        $validated['is_new_listing'] = $request->has('is_new_listing');

        // Update the plot with the validated data (EXCLUDE status)
        $validated['user_id'] = $user->id;
        unset($validated['status']); // Ensure status is not updated manually
        $plot->update($validated);

        // Remove images marked for removal
        if ($request->has('removed_images')) {
            foreach ($request->removed_images as $removedImagePath) {
                $plotImage = $plot->plotImages()->where('image_path', $removedImagePath)->first();
                if ($plotImage) {
                    // Delete the file from storage
                    if (FacadesStorage::disk('public')->exists($removedImagePath)) {
                        FacadesStorage::disk('public')->delete($removedImagePath);
                    }
                    $plotImage->delete();
                }
            }
        }

        // Only add new images (do not re-add existing images)
        if ($request->hasFile('images')) {
            $sortOrder = $plot->plotImages()->max('sort_order') ?? 0;
            foreach ($request->file('images') as $image) {
                if ($image->isValid()) {
                    $imagePath = $image->store('plots', 'public');
                    $plot->plotImages()->create([
                        'plot_id' => $plot->id,
                        'image_path' => $imagePath,
                        'alt_text' => $plot->title . ' - Image ' . ($sortOrder + 1),
                        'sort_order' => ++$sortOrder,
                        'is_primary' => false,
                    ]);
                }
            }
        }

        // Redirect with a success message to the plot details page
        return redirect()->route('admin.plots.show', $plot)
            ->with('success', 'Plot updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plot $plot)
    {
        // Prevent deleting reserved plots
        if ($plot->status === 'reserved') {
            return redirect()->route('admin.plots.index')
                ->with('reserved_error', true);
        }
        // Delete the plot
        $plot->delete();

        // Redirect with a success message
        return redirect()->route('admin.plots.index')
            ->with('success', 'Plot deleted successfully.');
    }

    /**
     * Search plots by title, description, location, price, and availability.
     */
    public function search(Request $request)
    {
        $query = Plot::query();

        // Handle general search parameter
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%')
                  ->orWhere('location', 'like', '%' . $searchTerm . '%')
                  ->orWhere('category', 'like', '%' . $searchTerm . '%')
                  ->orWhere('price', 'like', '%' . $searchTerm . '%')
                  ->orWhere('area_sqm', 'like', '%' . $searchTerm . '%');
            });
        }

        // Handle specific field searches
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

        // Apply sorting to search results
        $sort = $request->input('sort', 'latest');
        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'area_small':
                $query->orderBy('area_sqm', 'asc');
                break;
            case 'area_large':
                $query->orderBy('area_sqm', 'desc');
                break;
            case 'views':
                $query->orderBy('views', 'desc')->orderBy('created_at', 'desc');
                break;
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        $plots = $query->with('plotImages')->paginate(10)->appends($request->except('page'));

        return view('admin.plots.index', ["plots" => $plots]);
    }

    /**
     * Display a list of pending plots for admin approval.
     */
    public function pending()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        $plots = \App\Models\Plot::where('status', 'pending')->latest()->paginate(10);
        return view('admin.plots.pending', compact('plots'));
    }

    /**
     * Approve a pending plot.
     */
    public function approve($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        $plot = Plot::findOrFail($id);
        $plot->status = 'available';
        $plot->save();
        return redirect()->route('admin.plots.pending')->with('success', 'Plot approved successfully.');
    }

    /**
     * Reject a pending plot.
     */
    public function reject($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        $plot = Plot::findOrFail($id);
        $plot->status = 'rejected';
        $plot->save();
        return redirect()->route('admin.plots.pending')->with('success', 'Plot rejected.');
    }
}
