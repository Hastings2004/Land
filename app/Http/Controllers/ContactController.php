<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\ContactFormMail;
use App\Models\ContactSubmission;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:1000',
        ]);

        try {
            // Save the contact submission to database
            $submission = ContactSubmission::create([
                'name' => $request->name,
                'email' => $request->email,
                'message' => $request->message,
                'email_sent' => false,
            ]);

            Log::info('Contact form submission saved to database', [
                'id' => $submission->id,
                'name' => $request->name,
                'email' => $request->email,
            ]);

            // Try to send email if mail is configured
            try {
                Mail::to('info@atsogo.mw')->send(new ContactFormMail([
                    'name' => $request->name,
                    'email' => $request->email,
                    'message' => $request->message,
                ]));
                
                // Update submission as email sent successfully
                $submission->update(['email_sent' => true]);
                Log::info('Contact form email sent successfully');
                
            } catch (\Exception $mailException) {
                // Update submission with email error
                $submission->update([
                    'email_error' => $mailException->getMessage()
                ]);
                
                Log::warning('Contact form email failed, but submission was saved to database', [
                    'error' => $mailException->getMessage()
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Your message has been received! We\'ll get back to you soon. If urgent, please call us at +265 888 052 362.'
            ]);

        } catch (\Exception $e) {
            Log::error('Contact form error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Sorry, there was an error processing your message. Please call us directly at +265 888 052 362 or email info@atsogo.mw'
            ], 500);
        }
    }

    public function adminIndex()
    {
        $submissions = ContactSubmission::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.contact-submissions.index', compact('submissions'));
    }

    public function show(ContactSubmission $submission)
    {
        return view('admin.contact-submissions.show', compact('submission'));
    }
} 