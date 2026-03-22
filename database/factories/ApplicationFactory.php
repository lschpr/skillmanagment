<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\Assignment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Application>
 */
/**
 * Deze factory gebruik ik voor de sollicitaties. 
 * Hij maakt automatisch een opdracht en student aan als die nog niet bestaan.
 */
class ApplicationFactory extends Factory
{
    /**
     * De logica voor één nep-sollicitatie.
     */
    public function definition(): array
    {
        return [
            // Assignment::factory() maakt direct een nieuwe opdracht aan voor deze reactie.
            'assignment_id' => Assignment::factory(),
            
            // User factory met een 'state' om te dwingen dat het een student is.
            'user_id' => User::factory()->state(['role' => 'student']),
            
            // Met fake() maak ik een mooie random zin als motivatie.
            'message' => fake()->sentence(),
            
            'status' => 'pending',
        ];
    }
}
