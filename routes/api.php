<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;

// Grouping ticket-related routes for better organization
Route::middleware('auth:sanctum')->group(function () {
    // Get the currently authenticated user
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->name('user.profile');
});

// Routes related to tickets
Route::prefix('tickets')->group(function () {

    // Get all open (unprocessed) tickets
    Route::get('/open', [TicketController::class, 'openTickets'])->name('tickets.open');

    // Get all closed (processed) tickets
    Route::get('/closed', [TicketController::class, 'closedTickets'])->name('tickets.closed');
});

// Get tickets for a specific user
Route::get('/users/{userId}/tickets', [TicketController::class, 'userTickets'])->name('tickets.user');

// Stats endpoint to gather all ticket-related stats
Route::get('/stats', [TicketController::class, 'stats'])->name('tickets.stats');