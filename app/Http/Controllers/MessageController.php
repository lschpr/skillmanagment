<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewMessageReceived;

/**
 * Hier regel ik de chatfunctie op mijn site.
 */
class MessageController extends Controller
{
    /**
     * Overzicht van al mijn gesprekken.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Ik haal hier alle berichten op waar ik zelf bij betrokken ben.
        $messages = Message::where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->with(['sender', 'receiver'])
            ->latest()
            ->get();

        // En die groepeer ik dan per persoon, zodat het overzichtelijk blijft.
        $conversations = $messages->groupBy(function($message) use ($user) {
            return $message->sender_id == $user->id ? $message->receiver_id : $message->sender_id;
        });

        return view('messages.index', compact('conversations'));
    }

    /**
     * Het hele gesprek met één specifieke persoon bekijken.
     */
    public function show(User $user)
    {
        // Berichten ophalen die tussen mij en de andere user zijn verstuurd.
        $messages = Message::where(function($q) use ($user) {
            $q->where('sender_id', Auth::id())->where('receiver_id', $user->id);
        })->orWhere(function($q) use ($user) {
            $q->where('sender_id', $user->id())->where('receiver_id', Auth::id());
        })->orderBy('created_at', 'asc')->get();

        // Als ik het gesprek open, markeer ik alle ongelezen berichten direct als 'gelezen'.
        Message::where('sender_id', $user->id)
            ->where('receiver_id', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('messages.show', compact('messages', 'user'));
    }

    /**
     * Een nieuw berichtje sturen.
     */
    public function store(Request $request)
    {
        // Validatie: ik moet wel een ontvanger hebben en de tekst mag niet leeg zijn.
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required|string|max:1000',
        ]);

        $msg = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'content' => $request->content,
        ]);

        // Ik stuur ook gelijk een mailtje naar de ontvanger om te laten weten dat er een bericht is.
        Mail::to($msg->receiver->email)->send(new NewMessageReceived($msg));

        return back()->with('success', 'Je bericht is verzonden!');
    }
}
