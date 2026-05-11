<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Resend\Laravel\Facades\Resend;

class AdminMessageController extends Controller
{
    private $messagesFile = 'messages.json';

    public function index()
    {
        $messages = $this->getMessages();
        // Sort by created_at desc
        usort($messages, function ($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });

        return view('admin.messages.index', compact('messages'));
    }

    public function show($id)
    {
        $messages = $this->getMessages();
        $messageIndex = -1;

        foreach ($messages as $index => $msg) {
            if ($msg['id'] === $id) {
                $messages[$index]['read'] = true;
                $messageIndex = $index;
                break;
            }
        }

        if ($messageIndex === -1) {
            abort(404);
        }

        Storage::put($this->messagesFile, json_encode($messages));

        return view('admin.messages.index', [
            'message' => $messages[$messageIndex],
            'messages' => $messages
        ]);
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'reply' => 'required|string|max:5000',
        ]);

        $messages = $this->getMessages();
        $messageIndex = -1;

        foreach ($messages as $index => $msg) {
            if ($msg['id'] === $id) {
                $messages[$index]['reply'] = $request->reply;
                $messages[$index]['replied'] = true;
                $messageIndex = $index;
                break;
            }
        }

        if ($messageIndex === -1) {
            abort(404);
        }

        Storage::put($this->messagesFile, json_encode($messages));

        $msg = $messages[$messageIndex];

        // Send Email via Resend
        try {
            $settingsFile = 'settings.json';
            $settings = Storage::exists($settingsFile) ? json_decode(Storage::get($settingsFile), true) : [];
            $storeName = $settings['store_name'] ?? '7ETTA';

            Resend::emails()->send([
                'from' => $storeName . ' <contact@7etta.com>',
                'to' => [$msg['email']],
                'subject' => 'Re: ' . $msg['subject'],
                'html' => "<p>Hello " . $msg['name'] . ",</p><p>Thank you for contacting us. Regarding your message: <i>\"" . $msg['message'] . "\"</i></p><p><b>Our Response:</b></p><p>" . nl2br($request->reply) . "</p><p>Best regards,<br>" . $storeName . " Team</p>",
            ]);
        } catch (\Exception $e) {
            // Log or handle error
        }

        return redirect()->back()->with('success', 'Reply sent successfully!');
    }

    private function getMessages()
    {
        if (!Storage::exists($this->messagesFile)) {
            return [];
        }
        return json_decode(Storage::get($this->messagesFile), true) ?? [];
    }
}
