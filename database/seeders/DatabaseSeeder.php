<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PermissionsSeeder::class);
        $this->call(CurrenciesSeeder::class);
        $this->call(BanksSeeder::class);

        User::factory(10)->create()
            ->each(function ($user) {
                $user->assignRole('client');
        });
        User::factory(1)->create()
            ->each(function ($user) {
                $user->assignRole('admin');
        });
    }
}
