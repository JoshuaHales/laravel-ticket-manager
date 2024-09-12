<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'subject' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'status' => false, // Unprocessed by default
            'processed_at' => null, // Keep processed_at as null by default
            'user_id' => User::query()->inRandomOrder()->first()->id ?? User::factory() // Select a random user from the database, or create one if none exists
        ];
    }
}
