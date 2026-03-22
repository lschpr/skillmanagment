<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Dit model is voor de berichten tussen studenten en bedrijven.
 */
class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'content',
        'read_at',
    ];

    /**
     * Wie heeft het bericht verstuurd?
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Wie moet het bericht ontvangen?
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
