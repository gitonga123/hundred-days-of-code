<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\UpdateScores::class,
        Commands\ProcessMatch::class,
        Commands\UpdateTotalScores::class,
        Commands\UpdateSfDates::class,
        Commands\updateWinner::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command(\App\Console\Commands\UpdateScores::class)->everyThirtyMinutes()->withoutOverlapping(10)->runInBackground();
        $schedule->command(\App\Console\Commands\ProcessMatch::class)->everyThirtyMinutes()->withoutOverlapping(10)->runInBackground();
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
