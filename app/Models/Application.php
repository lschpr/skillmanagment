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
     * 'assignment_id': Voor het koppelen aan de opdracht (Foreign Key).
     * 'user_id': Voor het koppelen aan de student (Foreign Key).
     * 'status': Kan 'pending', 'accepted' of 'rejected' zijn.
     */
    protected $fillable = [
        'assignment_id',
        'user_id',
        'message',
        'status', 
    ];

    /**
     * De student die gereageerd heeft op de opdracht.
     * Ik gebruik de tweede parameter 'user_id' omdat mijn kolomnaam in de tabel 
     * niet 'user_id' maar 'student_id' had kunnen zijn, maar hier is het 'user_id'.
     */
    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * De opdracht waar de student op heeft gereageerd.
     * Dit is de tegenhanger van de 'applications' relatie in het Assignment model.
     */
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }
}
