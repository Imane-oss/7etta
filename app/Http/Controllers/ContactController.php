<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;

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

        // 2. Send email — wrapped in try/catch to prevent crashes
        try {
            Mail::to('7etta26@gmail.com')->send(new ContactMail($validated));

            return back()->with('success', '✅ Your message has been sent successfully! We\'ll get back to you within 24 hours.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', '❌ Something went wrong while sending your message. Please try again later or contact us directly by email.');
        }
    }
}
