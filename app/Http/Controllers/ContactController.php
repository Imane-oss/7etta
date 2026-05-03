<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;
use Resend\Laravel\Facades\Resend;

class ContactController extends Controller
{
    /**
     * Handle the contact form submission.
     */
    
    public function send(Request $request)
    {
        // 1. Validate
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        try {
            // 2. Send email using Resend Facade
            Resend::emails()->send([
                'from' => '7ETTA <contact@7etta.com>',
                'to' => ['7etta26@gmail.com'],
                'subject' => '[Contact Form] ' . $validated['subject'],
                'html' => view('emails.contact', [
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'subject' => $validated['subject'],
                    'body' => $validated['message'],
                ])->render(),
            ]);

            return back()->with('success', '✅ Message sent successfully via Resend!');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', '❌ Email failed: ' . $e->getMessage());
        }
    }
}
