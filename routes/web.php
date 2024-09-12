<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;

/**
 * Home Route
 * This route serves the default 'welcome' page.
 */
Route::get('/', function () {
    return view('welcome');
});

// Serve the same 'app' view for tickets
Route::view('/tickets', 'app');

// Serve the same 'app' view for user tickets
Route::view('/users/{identifier}/tickets', 'app');