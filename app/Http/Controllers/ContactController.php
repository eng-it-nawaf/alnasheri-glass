<?php

namespace App\Http\Controllers;

use App\Models\ContactRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('frontend.contact');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'phone' => [
                'required',
                'string',
                'max:30',
                'regex:/^\+?[0-9\s\-()]{7,25}$/',
            ],

            'email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'service_type' => [
                'nullable',
                'string',
                'max:255',
            ],

            'message_body' => [
                'required',
                'string',
                'min:10',
                'max:5000',
            ],
        ]);

        ContactRequest::create([
            ...$validated,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('contact')
            ->with(
                'success',
                'تم إرسال طلبك بنجاح، وسنتواصل معك قريباً.'
            );
    }
}