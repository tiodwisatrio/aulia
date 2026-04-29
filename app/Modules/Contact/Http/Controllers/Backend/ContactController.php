<?php

namespace App\Modules\Contact\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Mail\ContactReplyMail;
use App\Modules\Contact\Models\ContactMessage;
use App\Services\MailConfigService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactMessage::latest();

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('hubungi_kami_status', $request->status);
        }

        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('hubungi_kami_nama', 'like', '%' . $request->search . '%')
                  ->orWhere('hubungi_kami_email', 'like', '%' . $request->search . '%')
                  ->orWhere('hubungi_kami_subjek', 'like', '%' . $request->search . '%');
            });
        }

        $messages = $query->paginate(15);
        $newCount = ContactMessage::where('hubungi_kami_status', 'baru')->count();

        return view('contact::backend.index', compact('messages', 'newCount'));
    }

    public function show(ContactMessage $contact)
    {
        if ($contact->isNew()) {
            $contact->markAsRead();
        }

        $hubungi_kami = $contact;
        return view('contact::backend.show', compact('hubungi_kami'));
    }

    public function reply(Request $request, ContactMessage $contact)
    {
        $request->validate([
            'reply_message' => 'required|string'
        ]);

        try {
            MailConfigService::setMailConfig();

            Mail::to($contact->hubungi_kami_email)->send(
                new ContactReplyMail($contact, $request->reply_message)
            );

            $contact->update([
                'hubungi_kami_balasan_admin' => $request->reply_message,
                'hubungi_kami_status'        => 'dibalas',
                'hubungi_kami_dibalas_pada'  => now(),
            ]);

            return redirect()->route('contacts.show', $contact)
                ->with('success', 'Balasan berhasil dikirim!');
        } catch (\Exception $e) {
            return redirect()->route('contacts.show', $contact)
                ->with('error', 'Gagal mengirim email: ' . $e->getMessage());
        }
    }

    public function destroy(ContactMessage $contact)
    {
        $contact->delete();
        return redirect()->route('contacts.index')
            ->with('success', 'Pesan berhasil dihapus.');
    }
}
