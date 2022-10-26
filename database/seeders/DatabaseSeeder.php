<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        $userSeeder = new UserSeeder();
        $adSeeder = new AdSeeder();

        for ($i = 0; $i < 20; $i++) {
            $userSeeder->run();
        }

        for ($i = 0; $i < 100; $i++) {
            $adSeeder->run();
        }
    }

}
