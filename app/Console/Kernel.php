<?php

namespace App\Console;

use App\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
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
        // $schedule->command('inspire')
        //          ->hourly();
        $users = User::all();

        foreach ($users as $u){
            $this->u = $u;
            
            if(ctype_digit( $u->strava_id )) {
                $schedule->call(function (Request $stravaRequest) {
                    $stravaRequest::retrieveActivities($this->u);
                })->everyFiveMinutes();
            }
        }
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
