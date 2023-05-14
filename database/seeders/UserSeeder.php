<?php

namespace Database\Seeders;

use App\Services\UnsplashImagesService;
use App\Services\UploaderService;
use Exception;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    private static Generator $faker;

    public function __construct(
        private readonly UploaderService       $uploaderService,
        private readonly UnsplashImagesService $unsplashService
    )
    {
        self::$faker = Factory::create("en_GB");
    }

    public function run()
    {
        $gender = rand(0, 100) > 50 ? "male" : "female";
        $name = self::$faker->firstName($gender) . " " . self::$faker->lastName();
        $email = strtolower(preg_replace("|[\s.']+|", ".", $name));
        $email .= rand(0, 100) > 50 ? self::$faker->numberBetween(10, 99) : "";
        $email .= "@" . self::$faker->freeEmailDomain();
        $created = self::$faker->dateTimeBetween("-2 years");
        $phone = rand(0, 100) > 60 ? self::$faker->phoneNumber() : null;

        if (rand(0, 100) > 70) {
            $name = self::$faker->title($gender) . " " . $name;
        }

        $pic = null;
        try {
            $imageFilename = $this->unsplashService->downloadByTag("user profile $gender");
            $uploaded = new UploadedFile($imageFilename, "tmp.jpg");
            $pic = $this->uploaderService->uploadImage($uploaded, "1:1");
        } catch (Exception $e) {
            print_r($e->getMessage() . PHP_EOL);
        }

        DB::table('users')->insert([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'password' => Hash::make($email),
            'pic' => $pic,
            'created_at' => $created,
            'updated_at' => $created,
        ]);
    }

    public function makeDemoUser()
    {
        if (DB::table('users')->count() > 0) {
            return;
        }

        $created = self::$faker->dateTimeBetween("-2 years");
        DB::table('users')->insert([
            'name' => "Demo",
            'email' => "demouser@clovr.me",
            'phone' => "",
            'password' => Hash::make("demouser"),
            'created_at' => $created,
            'updated_at' => $created,
        ]);
    }
}
