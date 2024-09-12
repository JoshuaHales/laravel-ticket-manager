<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TicketApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test: Can get a list of open (unprocessed) tickets via the API.
     * 
     * This test checks if the API correctly returns the list of open tickets, which are tickets with 'status' set to false.
     * It creates a user, generates 3 open tickets for that user, and then verifies that the API response contains the correct structure and data.
     */
    public function test_can_get_open_tickets()
    {
        // Create a user using a factory
        $user = User::factory()->create();

        // Create 3 open tickets (status = false) for the created user
        Ticket::factory()->count(3)->create(['user_id' => $user->id, 'status' => false]);

        // Make a GET request to the API endpoint to retrieve open tickets
        $response = $this->getJson('/api/tickets/open');

        // Assert that the response status is 200 (OK)
        $response->assertStatus(200)
                // Assert that the JSON structure matches the expected format
                ->assertJsonStructure([
                    'data' => [
                        '*' => ['subject', 'content', 'status', 'user' => ['name', 'email']]
                    ]
                ])
                // Assert that there are exactly 3 tickets in the 'data' array
                ->assertJsonCount(3, 'data');
    }
}