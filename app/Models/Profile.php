<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Hier sla ik alle extra profiel-info op die niet in de standard users tabel staat.
 * Zoals de bio, skills en de locatie.
 */
class Profile extends Model
{
    use HasFactory;

    /**
     * 'cv_path' en 'logo_path': Hier sla ik de bestandsnaam op van de geüploade bestanden.
     * De One-to-One relatie met User wordt hieronder gedefinieerd.
     */
    protected $fillable = [
        'user_id',
        'bio',
        'skills',
        'location',
        'logo_path',
        'cv_path',
        'website',
    ];

    /**
     * Koppeling terug naar de gebruiker (User) waar dit profiel bij hoort.
     * Dit is de 'BelongsTo' kant van de One-to-One relatie.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
