<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Dit model gebruik ik voor alle opdrachten die bedrijven op het platform zetten.
 */
class Assignment extends Model
{
    use HasFactory;

    /**
     * Ik heb hier velden voor de titel, omschrijving en regio van de opdracht.
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'type',
        'region',
        'status',
    ];

    /**
     * Het bedrijf dat deze opdracht heeft geplaatst.
     */
    public function company()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Hier haal ik alle studenten op die op deze opdracht hebben gereageerd.
     */
    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
