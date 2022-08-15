<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            // UserRandomSeeder::class, switch between UserSeeder and UserRandomSeeder to get randomized seeder.
            FieldSeeder::class,
            AvatarSeeder::class,
            ProfileSeeder::class,
            InterestSeeder::class,
        ]);
    }
}
