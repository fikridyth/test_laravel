<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\SendEmailJob;

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
        // $schedule->command('new SendEmailJob')->dailyAt('09:00');
        $schedule->command('new SendEmailJob')->everyMinute();

        // $now = Carbon::now();
        // $month = $now->format('F');
        // $year = $now->format('yy');


        // $fourthFridayMonthly = new Carbon('fourth friday of ' . $month . ' ' . $year);

        // $schedule->job(new SendEmailJob)->dailyAt('09:00');
        $schedule->job(new SendEmailJob)->everyMinute();
    }


    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
