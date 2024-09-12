<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // This schedules the 'ticket:generate' command to run every minute.
        // This command generates a new dummy ticket on a minute-by-minute basis.
        $schedule->command('ticket:generate-ticket')->everyMinute();

        // This schedules the 'ticket:process-ticket' command to run every five minutes.
        // The command processes one unprocessed ticket in the system, 
        // marking it as 'processed' and triggering any related events.
        $schedule->command('ticket:process-ticket')->everyFiveMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
