<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        $userSeeder = new UserSeeder();

        for ($i = 0; $i < 10; $i++) {
            $userSeeder->run();
        }
    }

}
