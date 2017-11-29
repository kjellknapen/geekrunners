<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use NerdRunClub\Calculation;

class SaveMedals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'save:medals';

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
        $calculation = app()->make('Calculation');
        $calculation->saveMedals();
    }
}
