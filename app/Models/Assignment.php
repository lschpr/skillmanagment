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
     * De 'fillable' array bepaalt welke velden ik via een formulier mag vullen.
     * Dit beschermt mijn database tegen 'mass assignment' aanvallen.
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
     * Dit is een 'BelongsTo' relatie omdat de 'user_id' in deze tabel staat.
     */
    public function company()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Hier haal ik alle studenten op die op deze opdracht hebben gereageerd.
     * Dit is een 'HasMany' relatie: één opdracht kan veel reacties hebben.
     */
    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
