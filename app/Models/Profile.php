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
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
