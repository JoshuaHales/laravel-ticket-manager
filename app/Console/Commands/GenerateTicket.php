<?php

namespace App\Console\Commands;

use Exception;
use App\Models\Ticket;
use App\Events\TicketUpdated;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GenerateTicket extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ticket:generate-ticket';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates a ticket with dummy data every minute';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            // Create a dummy ticket using the factory
            $ticket = Ticket::factory()->create();

            // Fire event to notify about the new ticket
            event(new TicketUpdated($ticket));
            
            // Log and output success message
            Log::info('Ticket generated', ['ticket_id' => $ticket->id]);
            $this->info('Ticket generated: ' . $ticket->subject);
        } catch (Exception $e) {
            // Log the error and output it to the console
            Log::error('Error generating ticket: ' . $e->getMessage(), ['exception' => $e]);

            // Output error message to the console
            $this->error('Failed to generate ticket. Error: ' . $e->getMessage());
        }
    }
}
