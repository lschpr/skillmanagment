<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** 
     * HasFactory: Gebruik ik om makkelijk test-users te maken (seeding).
     * Notifiable: Hiermee kan ik mailtjes en meldingen sturen naar de gebruiker.
     */
    use HasFactory, Notifiable;

    /**
     * Standaard Laravel velden die 'ge-mass-assigned' mogen worden.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
    ];

    /**
     * Velden die verborgen moeten blijven in JSON-output.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Hier geef ik aan hoe velden in de database omgezet moeten worden.
     * Bijvoorbeeld: het wachtwoord wordt hier altijd gehasht als ik het opsla.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Een gebruiker heeft bij mij altijd één profiel met extra info (bio, skills, website).
     * Dit is een One-to-One relatie: Profile::class.
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * Als de gebruiker een bedrijf is, dan kan hij meerdere opdrachten (assignments) hebben geplaatst.
     * Dit is een One-to-Many relatie: Assignment::class.
     */
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    /**
     * Een student kan op verschillende opdrachten solliciteren (applications).
     * Ook dit is een One-to-Many relatie: Application::class.
     */
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    /**
     * Deze kleine helpers heb ik gemaakt om in mijn code (zoals Controllers en Views) 
     * heel snel te kunnen checken welke rol de ingelogde gebruiker heeft.
     * Dit houdt mijn code leesbaar: Auth::user()->isCompany().
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isStudent()
    {
        return $this->role === 'student';
    }

    public function isCompany()
    {
        return $this->role === 'company';
    }
}
