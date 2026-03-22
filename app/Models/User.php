<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'status'])]
#[Hidden(['password', 'remember_token'])]
/**
 * Dit is mijn User model. 
 * Ik gebruik 'Authenticatable' zodat Laravel dit model snapt voor het inloggen.
 */
class User extends Authenticatable
{
    /** 
     * HasFactory: Gebruik ik om makkelijk test-users te maken (seeding).
     * Notifiable: Hiermee kan ik mailtjes en meldingen sturen naar de gebruiker.
     */
    use HasFactory, Notifiable;

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
     * Een gebruiker heeft bij mij altijd één profiel met extra info (bio, skills, etc).
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * Als de gebruiker een bedrijf is, dan kan hij meerdere opdrachten (assignments) hebben geplaatst.
     */
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    /**
     * Een student kan op verschillende opdrachten solliciteren (applications).
     */
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    /**
     * Kleine helpers die ik heb gemaakt om snel de rol te checken in mijn code.
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
