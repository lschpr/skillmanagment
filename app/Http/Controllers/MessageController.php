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
     * Ik haal hier alle berichten op waar ik bij betrokken ben, als zender of ontvanger.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Met 'orWhere' zorg ik dat ik zowel verzonden als ontvangen berichten zie.
        $messages = Message::where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->with(['sender', 'receiver'])
            ->latest()
            ->get();

        // Groeperen: ik wil niet een lijst met losse berichten, maar gesprekken per persoon.
        // Deze collectie-methode regelt dat ik per unieke gesprekspartner een groepje krijg.
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
        // Ik gebruik hier een 'nested' query om precies de berichten tussen mij en de ander op te halen.
        $messages = Message::where(function($q) use ($user) {
            $q->where('sender_id', Auth::id())->where('receiver_id', $user->id);
        })->orWhere(function($q) use ($user) {
            $q->where('sender_id', $user->id)->where('receiver_id', Auth::id());
        })->orderBy('created_at', 'asc')->get();

        // Markeer als gelezen: als ik het gesprek open, markeer ik alle ongelezen berichten van de ander als gelezen.
        Message::where('sender_id', $user->id)
            ->where('receiver_id', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('messages.show', compact('messages', 'user'));
    }

    /**
     * Een nieuw berichtje sturen naar iemand.
     */
    public function store(Request $request)
    {
        // Validatie: ik check of de ontvanger bestaat en of het bericht niet leeg is.
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required|string|max:1000',
        ]);

        $msg = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'content' => $request->content,
        ]);

        // E-mailnotificatie: de ontvanger krijgt een seintje in zijn inbox.
        Mail::to($msg->receiver->email)->send(new NewMessageReceived($msg));

        return back()->with('success', 'Je bericht is verzonden!');
    }
}
