<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function __construct(
        private readonly AdSeeder   $adSeeder,
        private readonly UserSeeder $userSeeder,
    )
    {
    }

    public function run()
    {
        $this->userSeeder->makeDemoUser();
        for ($i = 0; $i < 5; $i++) {
            $this->userSeeder->run();
        }

        for ($i = 0; $i < 20; $i++) {
            $this->adSeeder->run();
        }
    }

}
