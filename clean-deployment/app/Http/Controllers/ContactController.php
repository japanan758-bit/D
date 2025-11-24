<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

        try {
            // Create contact message
            $contactMessage = ContactMessage::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'subject' => $request->subject,
                'message' => $request->message,
                'is_read' => false,
            ]);

            // Send notification email to clinic (optional)
            // Mail::to('info@akhrasclinic.com')->send(new ContactNotificationMail($contactMessage));

            return redirect()->back()
                ->with('success', 'تم إرسال رسالتك بنجاح! سنتواصل معك في أقرب وقت ممكن.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء إرسال الرسالة. يرجى المحاولة مرة أخرى.')
                ->withInput();
        }
    }
}