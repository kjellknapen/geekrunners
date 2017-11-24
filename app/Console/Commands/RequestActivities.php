<?php

namespace App\Console\Commands;

use App\Jobs\StravaActivityCall;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class RequestActivities extends Command
{
    protected $u;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'request:activity';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        if(Schema::hasTable('users')){
            $users = User::all();

            foreach ($users as $u){
                $this->u = $u;
                StravaActivityCall::dispatch($this->u);
            }
        }
    }
}
