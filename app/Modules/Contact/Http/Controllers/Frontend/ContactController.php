<?php

namespace App\Modules\Contact\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Modules\Contact\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact::frontend.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'hubungi_kami_nama'   => 'required|string|max:255',
            'hubungi_kami_email'  => 'required|email|max:255',
            'hubungi_kami_subjek' => 'required|string|max:255',
            'hubungi_kami_pesan'  => 'required|string|min:10',
        ]);

        $validated['hubungi_kami_ip_address'] = $request->ip();
        $validated['hubungi_kami_status']     = 'baru';

        ContactMessage::create($validated);

        return redirect()->back()->with('success', 'Pesan Anda telah terkirim. Kami akan segera menghubungi Anda.');
    }

    public function show(ContactMessage $contact)
    {
        if ($contact->hubungi_kami_status === 'baru') {
            $contact->markAsRead();
        }

        return view('contact::frontend.show', compact('contact'));
    }

    
}
