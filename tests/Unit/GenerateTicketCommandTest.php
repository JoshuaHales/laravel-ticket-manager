<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GenerateTicketCommandTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test: The console command generates a ticket.
     * 
     * This test checks if running the custom Artisan command 'ticket:generate-ticket'
     * successfully generates a new ticket in the database with the correct initial status.
     */
    public function test_console_command_generates_ticket()
    {
        // Assert that there are no tickets in the database initially
        $this->assertDatabaseCount('tickets', 0);

        // Run the Artisan command to generate a new ticket
        // This command should generate a new ticket in the database
        $this->artisan('ticket:generate-ticket')->assertExitCode(0);

        // Assert that there is now 1 ticket in the database
        $this->assertDatabaseCount('tickets', 1);

        // In this case, ensure that the ticket's status is 'unprocessed' (status = false)
        $this->assertDatabaseHas('tickets', ['status' => false]);
    }
}