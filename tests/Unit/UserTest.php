<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test: A user has many tickets.
     * 
     * This test verifies that the relationship between a user and tickets is correctly established,
     * meaning a user can have multiple tickets associated with them.
     */
    public function test_user_has_many_tickets()
    {
        // Create a user using a factory
        $user = User::factory()->create();

        // Create 3 tickets that belong to the created user
        Ticket::factory()->count(3)->create(['user_id' => $user->id]);

        // Assert that the user has exactly 3 tickets related to them
        // The 'tickets' relationship on the user model should return a collection of 3 tickets
        $this->assertCount(3, $user->tickets);
    }
}
