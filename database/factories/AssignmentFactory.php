<?php

namespace Database\Factories;

use App\Models\Assignment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Assignment>
 */
class AssignmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->state(['role' => 'company']),
            'title' => fake()->jobTitle() . ' Stage',
            'description' => fake()->paragraphs(3, true),
            'type' => fake()->randomElement(['stage', 'afstuderen', 'freelance']),
            'region' => fake()->city(),
            'status' => 'open',
        ];
    }
}
