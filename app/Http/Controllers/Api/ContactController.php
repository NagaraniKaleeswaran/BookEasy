<?php

namespace App\Http\Controllers\Api;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends BaseController
{
    /**
     * Store a new contact message.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $message = ContactMessage::create($request->all());

        return $this->sendResponse($message, 'Contact message sent successfully.');
    }

    /**
     * Get all contact messages (usually for admin, but included as per requirements).
     */
    public function index()
    {
        // Ideally this should be admin-only, but per requirements we'll expose it
        $messages = ContactMessage::orderBy('created_at', 'desc')->get();
        return $this->sendResponse($messages, 'Contact messages retrieved successfully.');
    }
}
