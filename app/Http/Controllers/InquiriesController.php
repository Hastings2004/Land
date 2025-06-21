<?php

namespace App\Http\Controllers;

use App\Models\Inquiries;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInquiriesRequest;
use App\Http\Requests\UpdateInquiriesRequest;
use Illuminate\Http\Request; // Import generic Request for index method if no specific Form Request for it
use Illuminate\Support\Facades\Auth;

class InquiriesController extends Controller
{
    /**
     * Display a listing of the resource (Inquiries).
     * This would typically be for an admin to view all inquiries.
     */
    public function index(Request $request)
    {
        // For admin panel: Fetch all inquiries, possibly with pagination
        // Add sorting, filtering, or searching as needed
        $user = Auth::user();

        // Retrieve inquiries where the 'email' column in the inquiries table
        // matches the email of the currently authenticated user.

        if ($user->role === 'admin') {
            $inquiries = Inquiries::latest()->paginate(15);
        } else {
            $inquiries = Inquiries::
                where('email', $user->email) 
                ->latest()
                ->paginate(15); // Order by latest and paginate
        }

        // Optional: Add search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = '%' . $request->search . '%';

            // Apply search functionality, ensuring it still filters by the user's email
            $inquiries = Inquiries::where('email', $user->email) // Still filter by user's email
                ->where(function($query) use ($searchTerm) {
                    $query->where('name', 'like', $searchTerm)
                        ->orWhere('email', 'like', $searchTerm)
                        ->orWhere('message', 'like', $searchTerm);
                })
                ->latest()
                ->paginate(15)
                ->appends(['search' => $request->search]); // Maintain search query in pagination links
        }

        $activeView = 'inquiries_index'; // For dashboard sidebar highlighting

        return view('inquiries.index', compact('inquiries', 'activeView'));
    }
    /**
     * Show the form for creating a new resource (Inquiry).
     * This is usually a public-facing form on the website (e.g., a contact form).
     */
    public function create()
    {
        // No specific data needed for an empty form
        return view('inquiries.create'); // For example, resources/views/inquiries/create.blade.php
    }

    /**
     * Store a newly created resource (Inquiry) in storage.
     * Handles the submission from the public inquiry form.
     */
    public function store(Request $request)
    {
        // The StoreInquiriesRequest handles validation and authorization.
        $validatedData = $request->validate([
             'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string',
            'plot_id' => 'nullable|exists:plots,id',
            'status' => 'nullable|string|in:new,viewed,responded,closed',
        ]);

        // Create the inquiry
        Inquiries::create($validatedData);

        // Redirect back with a success message, or to a thank you page
        return redirect()->back()
            ->with('success', 'Your inquiry has been sent successfully!');
            // Or: return redirect()->route('inquiry.thankyou');
    }

    /**
     * Display the specified resource (Inquiry).
     * This is typically for an admin to view details of a single inquiry.
     */
    public function show(Inquiries $inquiry) // Using Route Model Binding
    {
        $activeView = 'inquiries_show'; // For dashboard sidebar highlighting

        return view('inquiries.show', compact('inquiry', 'activeView'));
    }

    /**
     * Show the form for editing the specified resource (Inquiry).
     * This would primarily be an admin function to update inquiry status or details.
     */
    public function edit(Inquiries $inquiry) // Using Route Model Binding
    {
        $activeView = 'inquiries_edit'; // For dashboard sidebar highlighting

        return view('inquiries.edit', compact('inquiry', 'activeView'));
    }

    /**
     * Update the specified resource (Inquiry) in storage.
     * Handles the submission from the inquiry edit form (admin side).
     */
    public function update(UpdateInquiriesRequest $request, Inquiries $inquiry) // Using Route Model Binding
    {
        // The UpdateInquiriesRequest handles validation and authorization.
        $validatedData = $request->validated();

        // Update the inquiry
        $inquiry->update($validatedData);

        return redirect()->route('inquiries.index') // Redirect to the inquiries list
            ->with('success', 'Inquiry updated successfully!');
    }

    /**
     * Remove the specified resource (Inquiry) from storage.
     * This would typically be an admin function.
     */
    public function destroy(Inquiries $inquiry) // Using Route Model Binding
    {
        // Delete the inquiry
        $inquiry->delete();

        return redirect()->route('inquiries.index') // Redirect to the inquiries list
            ->with('success', 'Inquiry deleted successfully!');
    }
}