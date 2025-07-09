<?php

namespace App\Http\Controllers;

use App\Models\Inquiries;
use App\Models\Notification;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInquiriesRequest;
use App\Http\Requests\UpdateInquiriesRequest;
use Illuminate\Http\Request; // Import generic Request for index method if no specific Form Request for it
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class InquiriesController extends Controller
{
    /**
     * Display a listing of the resource (Inquiries).
     * This would typically be for an admin to view all inquiries.
     */
    public function index(Request $request)
    {
        // Customer view: Show only their own inquiries
        $user = Auth::user();
        $inquiries = Inquiries::where('email', $user->email)->latest()->paginate(15);

        // Optional: Add search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = '%' . $request->search . '%';
            $inquiries = Inquiries::where('email', $user->email)
                ->where(function($query) use ($searchTerm) {
                    $query->where('name', 'like', $searchTerm)
                        ->orWhere('email', 'like', $searchTerm)
                        ->orWhere('message', 'like', $searchTerm);
                })
                ->latest()
                ->paginate(15)
                ->appends(['search' => $request->search]);
        }

        return view('customer.inquiries.index', compact('inquiries'));
    }

    /**
     * Customer-specific methods
     */
    public function customerIndex(Request $request)
    {
        // Customer view: Show only their own inquiries that are not deleted
        $user = Auth::user();
        
        // Debug: Log the user's email
        \Illuminate\Support\Facades\Log::info('Customer inquiries query for email: ' . $user->email);
        
        $inquiries = Inquiries::where('email', $user->email)
            ->where('customer_deleted', false)
            ->latest()->paginate(15);
            
        // Debug: Log the count
        \Illuminate\Support\Facades\Log::info('Found ' . $inquiries->count() . ' inquiries for customer');

        // Optional: Add search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = '%' . $request->search . '%';
            $inquiries = Inquiries::where('email', $user->email)
                ->where('customer_deleted', false)
                ->where(function($query) use ($searchTerm) {
                    $query->where('name', 'like', $searchTerm)
                        ->orWhere('email', 'like', $searchTerm)
                        ->orWhere('message', 'like', $searchTerm);
                })
                ->latest()
                ->paginate(15)
                ->appends(['search' => $request->search]);
        }

        return view('customer.inquiries.index', compact('inquiries'));
    }

    public function customerCreate()
    {
        return view('customer.inquiries.create');
    }

    public function customerStore(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string',
            'plot_id' => 'nullable|exists:plots,id',
        ]);

        // Ensure the email matches the logged-in user's email
        $user = Auth::user();
        $validatedData['email'] = $user->email;
        
        // Debug: Log the inquiry creation
        \Illuminate\Support\Facades\Log::info('Creating inquiry for user: ' . $user->email);

        // Create the inquiry
        $inquiry = Inquiries::create($validatedData);
        
        // Debug: Log the created inquiry
        \Illuminate\Support\Facades\Log::info('Created inquiry ID: ' . $inquiry->id . ' for email: ' . $inquiry->email);

        // Create immediate notification for admin
        Notification::create([
            'type' => 'inquiry_received',
            'title' => '🚨 New Inquiry Received',
            'message' => "New inquiry from {$validatedData['name']} ({$validatedData['email']}) - {$validatedData['message']}",
            'inquiry_id' => $inquiry->id,
            'data' => [
                'customer_name' => $validatedData['name'],
                'customer_email' => $validatedData['email'],
                'customer_phone' => $validatedData['phone'],
                'inquiry_message' => $validatedData['message'],
                'plot_id' => $validatedData['plot_id'] ?? null,
                'inquiry_id' => $inquiry->id
            ]
        ]);

        // Return JSON response for AJAX requests
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Your inquiry has been sent successfully!',
                'inquiry_id' => $inquiry->id
            ]);
        }

        return redirect()->route('customer.inquiries.index')
            ->with('success', 'Your inquiry has been sent successfully!');
    }

    public function customerShow(Inquiries $inquiry)
    {
        // Ensure customer can only view their own inquiry
        if ($inquiry->email !== Auth::user()->email) {
            abort(403, 'Unauthorized access to inquiry.');
        }

        return view('customer.inquiries.show', compact('inquiry'));
    }

    public function customerEdit(Inquiries $inquiry)
    {
        // Ensure customer can only edit their own inquiry
        if ($inquiry->email !== Auth::user()->email) {
            abort(403, 'Unauthorized access to inquiry.');
        }

        return view('customer.inquiries.edit', compact('inquiry'));
    }

    public function customerUpdate(Request $request, Inquiries $inquiry)
    {
        // Ensure customer can only update their own inquiry
        if ($inquiry->email !== Auth::user()->email) {
            abort(403, 'Unauthorized access to inquiry.');
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string',
            'plot_id' => 'nullable|exists:plots,id',
        ]);

        $inquiry->update($validatedData);

        return redirect()->route('customer.inquiries.show', $inquiry)
            ->with('success', 'Inquiry updated successfully!');
    }

    public function adminUpdate(Request $request, Inquiries $inquiry)
    {
        $validatedData = $request->validate([
            'status' => 'required|string|in:new,viewed,responded,closed',
            'admin_response' => 'nullable|string',
        ]);

        $oldStatus = $inquiry->status;
        $inquiry->update($validatedData);

        // If status changed to 'responded' and admin added a response, notify customer
        if ($oldStatus !== 'responded' && $validatedData['status'] === 'responded' && !empty($validatedData['admin_response'])) {
            Notification::create([
                'type' => 'inquiry_responded',
                'title' => '💬 Response to Your Inquiry',
                'message' => "Admin has responded to your inquiry: {$inquiry->name}",
                'email' => $inquiry->email,
                'inquiry_id' => $inquiry->id,
                'data' => [
                    'inquiry_subject' => $inquiry->name,
                    'admin_response' => $validatedData['admin_response'],
                    'inquiry_id' => $inquiry->id
                ]
            ]);
        }

        return redirect()->route('admin.inquiries.index')
            ->with('success', 'Inquiry updated successfully!');
    }

    public function customerDestroy(Inquiries $inquiry)
    {
        // Ensure customer can only "delete" their own inquiry
        if ($inquiry->email !== Auth::user()->email) {
            abort(403, 'Unauthorized access to inquiry.');
        }

        // Soft delete for customer: set customer_deleted to true
        $inquiry->customer_deleted = true;
        $inquiry->save();

        return redirect()->route('customer.inquiries.index')
            ->with('success', 'Inquiry deleted successfully!');
    }

    public function customerRestore(Inquiries $inquiry)
    {
        if ($inquiry->email !== Auth::user()->email) {
            abort(403, 'Unauthorized access to inquiry.');
        }
        // Only restore if it was soft-deleted (not permanently deleted)
        if ($inquiry->customer_deleted) {
            $inquiry->customer_deleted = false;
            $inquiry->save();
            return redirect()->route('customer.inquiries.index')->with('success', 'Inquiry restored successfully!');
        }
        return redirect()->route('customer.inquiries.index')->with('error', 'Cannot restore permanently deleted inquiry.');
    }

    public function customerPermanentDelete(Inquiries $inquiry)
    {
        if ($inquiry->email !== Auth::user()->email) {
            abort(403, 'Unauthorized access to inquiry.');
        }
        // Permanent delete for customer: set customer_deleted to true (cannot be restored)
        $inquiry->customer_deleted = true;
        $inquiry->save();
        return redirect()->route('customer.inquiries.index')->with('success', 'Inquiry permanently deleted from your view!');
    }

    /**
     * Admin view: Show all inquiries
     */
    public function adminIndex(Request $request)
    {
        $inquiries = Inquiries::where('admin_deleted', false)->latest()->paginate(15);

        // Optional: Add search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = '%' . $request->search . '%';
            $inquiries = Inquiries::where('admin_deleted', false)
                ->where(function($query) use ($searchTerm) {
                $query->where('name', 'like', $searchTerm)
                    ->orWhere('email', 'like', $searchTerm)
                    ->orWhere('message', 'like', $searchTerm);
            })
            ->latest()
            ->paginate(15)
            ->appends(['search' => $request->search]);
        }

        return view('admin.inquiries.index', compact('inquiries'));
    }

    public function adminRestore(Inquiries $inquiry)
    {
        // Only restore if it was soft-deleted (not permanently deleted)
        if ($inquiry->admin_deleted) {
            $inquiry->admin_deleted = false;
            $inquiry->save();
            return redirect()->route('admin.inquiries.index')->with('success', 'Inquiry restored successfully!');
        }
        return redirect()->route('admin.inquiries.index')->with('error', 'Cannot restore permanently deleted inquiry.');
    }

    public function adminPermanentDelete(Inquiries $inquiry)
    {
        // Permanent delete for admin: set admin_deleted to true (cannot be restored)
        $inquiry->admin_deleted = true;
        $inquiry->save();
        return redirect()->route('admin.inquiries.index')->with('success', 'Inquiry permanently deleted from admin view!');
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

        return view('admin.inquiries.show', compact('inquiry', 'activeView'));
    }

    /**
     * Show the form for editing the specified resource (Inquiry).
     * This would primarily be an admin function to update inquiry status or details.
     */
    public function edit(Inquiries $inquiry) // Using Route Model Binding
    {
        $activeView = 'inquiries_edit'; // For dashboard sidebar highlighting

        return view('admin.inquiries.edit', compact('inquiry', 'activeView'));
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

        return redirect()->route('admin.inquiries.index') // Redirect to the inquiries list
            ->with('success', 'Inquiry updated successfully!');
    }

    /**
     * Remove the specified resource (Inquiry) from storage.
     * This would typically be an admin function.
     */
    public function destroy(Inquiries $inquiry) // Using Route Model Binding
    {
        // Soft delete for admin: set admin_deleted to true
        $inquiry->admin_deleted = true;
        $inquiry->save();

        return redirect()->route('admin.inquiries.index') // Redirect to the inquiries list
            ->with('success', 'Inquiry deleted successfully!');
    }
}
