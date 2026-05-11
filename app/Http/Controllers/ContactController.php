<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;
use Resend\Laravel\Facades\Resend;
use Illuminate\Support\Facades\Storage;

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
            $settingsFile = 'settings.json';
            $settings = Storage::exists($settingsFile) ? json_decode(Storage::get($settingsFile), true) : [];
            $contactEmail = $settings['contact_email'] ?? '7etta26@gmail.com';
            $storeName = $settings['store_name'] ?? '7ETTA';

            // 2. Save to JSON file
            $messagesFile = 'messages.json';
            $messages = Storage::exists($messagesFile) ? json_decode(Storage::get($messagesFile), true) : [];
            
            $newMessage = [
                'id' => uniqid(),
                'name' => $validated['name'],
                'email' => $validated['email'],
                'subject' => $validated['subject'],
                'message' => $validated['message'],
                'read' => false,
                'replied' => false,
                'reply' => null,
                'created_at' => now()->toDateTimeString(),
            ];

            $messages[] = $newMessage;
            Storage::put($messagesFile, json_encode($messages));

            // 3. Send notification email using Resend Facade
            Resend::emails()->send([
                'from' => $storeName . ' <contact@7etta.com>',
                'to' => [$contactEmail],
                'subject' => '[New Message] ' . $validated['subject'],
                'html' => view('emails.contact', [
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'subject' => $validated['subject'],
                    'body' => $validated['message'],
                ])->render(),
            ]);

            return back()->with('success', '✅ Message sent successfully!');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', '❌ Error: ' . $e->getMessage());
        }
    }
}
