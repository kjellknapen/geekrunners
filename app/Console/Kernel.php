<?php

namespace App\Console;

use App\Jobs\StravaActivityCall;
use App\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use NerdRunClub\Request;
use Illuminate\Database\Schema

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
	if(Schema::hasTable('users')){
        $users = User::all();

        foreach ($users as $u){
            $this->u = $u;
            $schedule->call(function (Request $request) {
                StravaActivityCall::dispatch($this->u, $request);
            });
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
