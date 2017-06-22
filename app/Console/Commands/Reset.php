<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class Reset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'epos:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Resets the EPOS system.';

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
        setting()->forget();

        User::destroy(1);
    }
}
