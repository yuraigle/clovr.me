<?php

namespace Database\Seeders;

use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    private static Generator $faker;

    public function __construct()
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

        DB::table('users')->insert([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'password' => Hash::make($email),
            'created_at' => $created,
            'updated_at' => $created,
        ]);
    }
}
