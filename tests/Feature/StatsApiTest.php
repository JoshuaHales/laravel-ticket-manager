<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StatsApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test: The stats endpoint returns the correct data.
     * 
     * This test checks if the stats endpoint correctly returns statistics about the tickets in the system.
     * It creates a user and 5 unprocessed tickets (status = false) and verifies the structure and content of the response.
     */
    public function test_stats_endpoint_returns_correct_data()
    {
        // Create a user using a factory
        $user = User::factory()->create();

        // Create 5 unprocessed tickets (status = false) for the created user
        Ticket::factory()->count(5)->create(['user_id' => $user->id, 'status' => false]);

        // Make a GET request to the API endpoint to retrieve ticket stats
        $response = $this->getJson('/api/stats');

        // Assert that the response status is 200 (OK)
        $response->assertStatus(200)
                // Assert that the JSON structure matches the expected format
                ->assertJsonStructure([
                    'total_tickets',
                    'unprocessed_tickets',
                    'user_with_most_tickets' => ['name', 'email'],
                    'last_processed'
                ]);
    }
}