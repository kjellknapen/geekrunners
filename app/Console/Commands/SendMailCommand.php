<?php

namespace App\Console\Commands;

use App\Notifications\WeeklyGoalMail;
use App\Schedules;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use NerdRunClub\Calculation;

class SendMailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public $users;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $calculation = app()->make('Calculation');
        $this->users = User::all();
        foreach ($this->users as $u){
            if($u->notifications == true && $u->email != "" && $calculation->getEndDate() != null) {
                $week = $calculation->currentWeek();
                $schedules = Schedules::all()->where('id', $week);

                foreach ($schedules as $schedule) {;
                    $frequency_goal= $schedule->frequency_goal;
                    $distance_goal= $schedule->distance_goal;
                }
                $calcs = $calculation->userScheduleDate($u, $distance_goal, $frequency_goal);
                $distance = $calcs['distance_progress'];
                $frequency = $calcs['frequency_progress'];
                if($frequency < 100 || $distance < 100) {
                    $u->notify(new WeeklyGoalMail($u->email, $calcs));
                }
            }
        }
    }
}
