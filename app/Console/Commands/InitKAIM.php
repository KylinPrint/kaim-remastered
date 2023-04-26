<?php

namespace App\Console\Commands;

use Database\Seeders\AdminDebugSeeder;
use Database\Seeders\AdminMenuSeeder;
use Illuminate\Console\Command;

class InitKAIM extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kaim:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize KAIM instance';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->initDatabase();

        return Command::SUCCESS;
    }

    /**
     * Create tables and seed it.
     *
     * @return void
     */
    public function initDatabase()
    {
        // TODO: 菜单权限控制
        $this->info('Now running admin:install...');
        $this->call('admin:install');

        $menuModel = config('admin.database.menu_model');

        if ($menuModel::count() <= 7) {
            $this->info('Now running Admin menu seeder...');
            $this->call('db:seed', ['--class' => AdminMenuSeeder::class]);
        }

        if (env('APP_DEBUG')) {
            $this->info('Debug mode on, now generating Fake Data...');
            $this->call('db:seed', ['--class' => AdminDebugSeeder::class]);
        }
    }
}
