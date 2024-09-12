<?php

namespace App\Console\Commands;

use Exception;
use App\Models\Ticket;
use App\Events\TicketUpdated;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ProcessTicket extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ticket:process-ticket';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Processes a ticket every five minutes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            // Fetch the oldest unprocessed ticket
            $ticket = Ticket::where('status', false)->orderBy('created_at', 'asc')->first();

            if ($ticket) {
                // Update the ticket's status and processed timestamp
                $ticket->update([
                    'status' => true,
                    'processed_at' => now(),
                ]);
                
                // Trigger the TicketUpdated event
                event(new TicketUpdated($ticket));

                // Log the successful processing
                Log::info('Ticket processed', ['ticket_id' => $ticket->id, 'subject' => $ticket->subject]);

                // Output the success message
                $this->info('Ticket processed: ' . $ticket->subject);
            } else {
                // No tickets to process
                $this->info('No unprocessed tickets found.');
                Log::info('No unprocessed tickets available to process.');
            }
        } catch (Exception $e) {
            // Log the error and provide feedback in the console
            Log::error('Error processing ticket: ' . $e->getMessage(), ['exception' => $e]);

            // Output error message
            $this->error('Failed to process ticket. Error: ' . $e->getMessage());
        }
    }
}
