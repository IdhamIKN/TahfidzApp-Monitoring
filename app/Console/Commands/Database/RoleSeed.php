<?php

namespace App\Console\Commands\Database;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class RoleSeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:role:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seeding Role';

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
        $this->line('Menyuntikkan Role Ke Database');

        // Command Artisan [Parameter]
        Artisan::call('db:seed', [
            '--class' => 'RoleTableSeeder'
        ]);

        info('Berhasil Disuntikkan.');
    }
}
