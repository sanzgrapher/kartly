<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormMail;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show()
    {
        $supportEmail = config('mail.from.address', 'support@example.com');
        return view('contact', compact('supportEmail'));
    }

    public function submit(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:5000',
        ]);

        // Send to all admin users if present, otherwise fallback to configured admin email
        $adminEmails = User::where('role', UserRole::ADMIN->value)->pluck('email')->filter()->values()->all();

        if (count($adminEmails) > 0) {
            try {
                Log::info('Contact form: queuing to admins', ['to' => $adminEmails]);
                Mail::to($adminEmails)->queue(new ContactFormMail($data));
            } catch (\Exception $e) {
                Log::error('Contact form mail failed (admins): ' . $e->getMessage(), $data);
                return redirect()->route('contact')->withErrors('Unable to send your message right now. Please try again later.');
            }
        } else {
            try {
                $to = config('mail.admin_address', config('mail.from.address', 'support@example.com'));
                Log::info('Contact form: queuing to fallback', ['to' => $to]);
                Mail::to($to)->queue(new ContactFormMail($data));
            } catch (\Exception $e) {
                Log::error('Contact form mail failed (fallback): ' . $e->getMessage(), $data);
                return redirect()->route('contact')->withErrors('Unable to send your message right now. Please try again later.');
            }
        }

        return redirect()->route('contact')->with('status', 'Thanks for reaching out! We will get back to you shortly.');
    }
}
