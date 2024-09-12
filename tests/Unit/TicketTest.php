<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TicketTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test: A ticket belongs to a user.
     * 
     * This test verifies that a ticket has a relationship with a user.
     * It ensures that when a ticket is created with a user_id, the 'user' relationship works correctly.
     */
    public function test_ticket_belongs_to_user()
    {
        // Create a user using the factory
        $user = User::factory()->create();

        // Create a ticket that belongs to the created user
        $ticket = Ticket::factory()->create(['user_id' => $user->id]);

        // Assert that the 'user' relationship on the ticket model returns an instance of the User class
        $this->assertInstanceOf(User::class, $ticket->user);
    }

    /**
     * Test: Ticket status defaults to unprocessed (false).
     * 
     * This test checks that when a ticket is created, its status defaults to 'false' (unprocessed).
     */
    public function test_ticket_status_defaults_to_unprocessed()
    {
        // Create a ticket using the factory with status set to false (unprocessed)
        $ticket = Ticket::factory()->create(['status' => false]);

        // Assert that the ticket's status is false (unprocessed)
        $this->assertFalse($ticket->status);
    }
}
