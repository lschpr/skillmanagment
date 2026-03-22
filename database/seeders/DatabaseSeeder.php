<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * De DatabaseSeeder is mijn startpunt voor testdata. 
 * Als ik 'php artisan migrate:fresh --seed' draai, wordt dit uitgevoerd.
 */
class DatabaseSeeder extends Seeder
{
    /**
     * De 'run' methode wordt aangeroepen door 'php artisan db:seed'.
     * Ik zet hier alle testdata klaar voor mijn platform.
     */
    public function run(): void
    {
        // 1. Mijn eigen admin account aanmaken.
        // Ik gebruik de 'UserFactory' om snel een account te maken met een vaste rol.
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@skillmanagment.nl',
            'role' => 'admin',
            'password' => bcrypt('password123'),
        ]);

        // 2. Een voorbeeld bedrijf maken met een profiel en wat opdrachten.
        $company = User::factory()->create([
            'name' => 'Creative Code BV',
            'email' => 'info@creativecode.nl',
            'role' => 'company',
            'password' => bcrypt('password123'),
        ]);
        
        // Relatie gebruiken om het profiel direct te koppelen.
        $company->profile()->create([
            'bio' => 'Wij bouwen de toekomst van het internet.',
            'location' => 'Amsterdam',
            'website' => 'https://creativecode.nl',
        ]);

        // Direct 5 opdrachten (assignments) koppelen aan dit bedrijf via de factory.
        \App\Models\Assignment::factory(5)->create([
            'user_id' => $company->id,
        ]);

        // 3. Een standaard student account maken.
        $student = User::factory()->create([
            'name' => 'Jan Student',
            'email' => 'student@skillmanagment.nl',
            'role' => 'student',
            'password' => bcrypt('password123'),
        ]);
        
        $student->profile()->create([
            'bio' => 'Gepassioneerde Laravel developer in wording.',
            'skills' => 'PHP, Laravel, Tailwind CSS, Alpine.js',
            'location' => 'Utrecht',
        ]);

        // 4. En nog 10 extra willekeurige opdrachten om de database te vullen.
        // De 'AssignmentFactory' regelt hier de willekeurige teksten en regio's.
        \App\Models\Assignment::factory(10)->create();
    }
}
