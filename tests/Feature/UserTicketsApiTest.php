<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTicketsApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that tickets can be fetched using a user ID.
     */
    public function test_can_get_tickets_by_user_id()
    {
        $user = User::factory()->create();
        Ticket::factory()->count(2)->create(['user_id' => $user->id]);

        $response = $this->getJson("/api/users/{$user->id}/tickets");

        $response->assertStatus(200)
                 ->assertJsonCount(2, 'data')
                 ->assertJsonPath('data.0.user.id', $user->id)
                 ->assertJsonPath('data.1.user.id', $user->id);
    }

    /**
     * Test that tickets can be fetched using a user's email.
     */
    public function test_can_get_tickets_by_user_email()
    {
        $user = User::factory()->create();
        Ticket::factory()->count(2)->create(['user_id' => $user->id]);

        $response = $this->getJson("/api/users/{$user->email}/tickets");

        $response->assertStatus(200)
                 ->assertJsonCount(2, 'data')
                 ->assertJsonPath('data.0.user.id', $user->id)
                 ->assertJsonPath('data.1.user.id', $user->id);
    }

    /**
     * Test that an error is returned when the user is not found.
     */
    public function test_error_if_user_not_found()
    {
        // Send a request with a non-existing user ID
        $response = $this->getJson("/api/users/9999/tickets");

        // Assert that a 404 error is returned with the updated error message
        $response->assertStatus(404)
                 ->assertJson(['error' => 'User not found']);

        // Send a request with a non-existing user email
        $response = $this->getJson("/api/users/nonexistent@example.com/tickets");

        // Assert that a 404 error is returned with the updated error message
        $response->assertStatus(404)
                 ->assertJson(['error' => 'User not found']);
    }
}