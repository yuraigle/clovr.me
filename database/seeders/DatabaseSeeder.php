<?php

namespace Database\Seeders;

use App\Services\UploaderService;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    protected UploaderService $uploaderService;

    /**
     * @param UploaderService $uploaderService
     */
    public function __construct(UploaderService $uploaderService)
    {
        $this->uploaderService = $uploaderService;
    }


    public function run()
    {
        $userSeeder = new UserSeeder();
        $adSeeder = new AdSeeder($this->uploaderService);

        $userSeeder->makeDemoUser();

        for ($i = 0; $i < 5; $i++) {
            $userSeeder->run();
        }

        for ($i = 0; $i < 1; $i++) {
            $adSeeder->run();
        }
    }

}
