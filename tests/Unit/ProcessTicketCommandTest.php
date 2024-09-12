<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProcessTicketCommandTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test: The console command processes a ticket.
     * 
     * This test verifies that the custom Artisan command 'ticket:process-ticket'
     * successfully processes an existing unprocessed ticket by changing its status to true.
     */
    public function test_console_command_processes_ticket()
    {
        // Create an unprocessed ticket (status = false)
        $ticket = Ticket::factory()->create(['status' => false]);

        // Run the Artisan command to process the ticket
        // The command should process the first unprocessed ticket
        $this->artisan('ticket:process-ticket')->assertExitCode(0);

        // Assert that the ticket's status has been updated to 'processed' (status = true)
        $this->assertDatabaseHas('tickets', ['id' => $ticket->id, 'status' => true]);
    }
}