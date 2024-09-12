<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\TicketResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TicketController extends Controller
{
    /**
     * Returns a paginated list of open (unprocessed) tickets with their associated users.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function openTickets()
    {
        try {
            // Fetch open tickets (status = false) along with user details
            $tickets = Ticket::open()->with('user:id,name,email')->paginate(3);

            return TicketResource::collection($tickets);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error fetching open tickets: ' . $e->getMessage());

            // Return a 500 error response
            return response()->json(['error' => 'Failed to fetch open tickets'], 500);
        }
    }

    /**
     * Returns a paginated list of closed (processed) tickets with their associated users.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function closedTickets()
    {
        try {
            // Fetch closed tickets (status = true) along with user details
            $tickets = Ticket::closed()->with('user:id,name,email')->paginate(3);

            return TicketResource::collection($tickets);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error fetching closed tickets: ' . $e->getMessage());

            // Return a 500 error response
            return response()->json(['error' => 'Failed to fetch closed tickets'], 500);
        }
    }

    /**
     * Returns a paginated list of tickets for a specific user.
     *
     * @param int $userId
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function userTickets($identifier)
    {
        try {
            // Determine if the identifier is a number (ID) or an email address
            if (is_numeric($identifier)) {
                // Fetch user by ID
                $user = User::where('id', $identifier)->firstOrFail();
            } else {
                // Fetch user by email
                $user = User::where('email', $identifier)->firstOrFail();
            }

            // Fetch tickets for the user
            $tickets = Ticket::where('user_id', $user->id)->with('user:id,name,email')->paginate(3);

            return TicketResource::collection($tickets);
        } catch (ModelNotFoundException $e) {
            // Return a 404 error response if the user is not found
            return response()->json(['error' => 'User not found'], 404);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error fetching tickets for user ' . $identifier . ': ' . $e->getMessage());

            // Return a 500 error response for any other errors
            return response()->json(['error' => 'Failed to fetch user tickets'], 500);
        }
    }

    /**
     * Returns ticket statistics, including total tickets, unprocessed tickets,
     * the user with the most tickets, and the time of the last processed ticket.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function stats()
    {
        try {
            // Fetch statistics about tickets
            $totalTickets = Ticket::count();
            $unprocessedTickets = Ticket::open()->count();
            $userWithMostTickets = User::withCount('tickets')->orderBy('tickets_count', 'desc')->first();
            $lastProcessed = Ticket::closed()->latest('processed_at')->first()->processed_at ?? 'No processed tickets';

            // Return the statistics as a JSON response
            return response()->json([
                'total_tickets' => $totalTickets,
                'unprocessed_tickets' => $unprocessedTickets,
                'user_with_most_tickets' => $userWithMostTickets,
                'last_processed' => $lastProcessed,
            ]);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error fetching ticket stats: ' . $e->getMessage());

            // Return a 500 error response
            return response()->json(['error' => 'Failed to fetch ticket stats'], 500);
        }
    }
}