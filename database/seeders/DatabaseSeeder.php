<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use LeadBrowser\Admin\Database\Seeders\DatabaseSeeder as AdminDatabaseSeeder;
use LeadBrowser\Core\Database\Seeders\DatabaseSeeder as CoreDatabaseSeeder;
use LeadBrowser\User\Database\Seeders\DatabaseSeeder as UserDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminDatabaseSeeder::class);
        $this->call(CoreDatabaseSeeder::class);
        $this->call(UserDatabaseSeeder::class);
        $this->call(WorldDatabaseSeeder::class);
    }
}