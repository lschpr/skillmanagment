<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Dit model is voor de reacties (sollicitaties) van studenten op opdrachten.
 */
class Application extends Model
{
    use HasFactory;

    /**
     * Deze velden mogen 'ge-mass-assigned' worden (handig bij het opslaan vanuit een formulier).
     */
    protected $fillable = [
        'assignment_id',
        'user_id',
        'message',
        'status', // Hier sla ik op of het geaccepteerd of afgewezen is.
    ];

    /**
     * De student die gereageerd heeft op de opdracht.
     */
    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * De opdracht waar de student op heeft gereageerd.
     */
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }
}
