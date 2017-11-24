<?php

namespace App\Jobs;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use NerdRunClub\Request;

class StravaActivityCall implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $u;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($u)
    {
        $this->u = $u;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $stravaRequest = app()->make('Request');
        $stravaRequest::retrieveActivities($this->u);
    }
}
