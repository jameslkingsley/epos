<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'epos:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installs the EPOS system.';

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
        // Printer
        setting()->set('peripheral:printer', 'App\\Basket\\Printers\\StarWebPrint');
        setting()->set('peripheral:printer:ip', '192.168.123.189');
        setting()->set('peripheral:printer:port', '80');

        // Company
        setting()->set('company:name', 'EPOS');
        setting()->set('company:telephone', '12345 456789');
        setting()->set('company:vat_number', '123 456 789');

        // Create admin user account
        User::create([
            'username' => 'Admin',
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password')
        ]);

        User::create([
            'username' => 'Test',
            'first_name' => 'Test',
            'last_name' => 'Test',
            'email' => 'test@test.com',
            'password' => Hash::make('password')
        ]);
    }
}
