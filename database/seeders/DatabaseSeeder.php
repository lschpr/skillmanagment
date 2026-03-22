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
     * Hier staat mijn hele rijtje met data die ik wil hebben.
     */
    public function run(): void
    {
        // 1. Mijn eigen admin account aanmaken.
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
        
        $company->profile()->create([
            'bio' => 'Wij bouwen de toekomst van het internet.',
            'location' => 'Amsterdam',
            'website' => 'https://creativecode.nl',
        ]);

        // Direct 5 opdrachten koppelen aan dit bedrijf.
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

        // 4. En nog 10 extra willekeurige opdrachten om de boel te vullen.
        \App\Models\Assignment::factory(10)->create();
    }
}
