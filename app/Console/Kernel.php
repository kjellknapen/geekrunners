<?php

namespace App\Console;

use App\Jobs\StravaActivityCall;
use App\Notifications\WeeklyGoalMail;
use App\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Schema;
use NerdRunClub\Request;

class Kernel extends ConsoleKernel
{
    protected $u;
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('request:activity')->everyFifteenMinutes();
        $schedule->command('send:mail')->cron('10 10 * * 5');
        $schedule->command('save:medals')->cron('59 23 * * 7');
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
