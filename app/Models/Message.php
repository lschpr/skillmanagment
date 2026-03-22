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

    /**
     * 'sender_id' en 'receiver_id' zijn beide gekoppeld aan de User tabel.
     * Ik gebruik 'read_at' om bij te houden of een bericht al gelezen is.
     */
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'content',
        'read_at',
    ];

    /**
     * Wie heeft het bericht verstuurd?
     * Dit is een 'BelongsTo' relatie naar de User kals.
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Wie moet het bericht ontvangen?
     * Ook dit is een 'BelongsTo' relatie naar de User klas.
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
