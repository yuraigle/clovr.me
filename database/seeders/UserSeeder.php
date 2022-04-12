<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create("en_IE");

        $gender = rand(0, 100) > 50 ? "male" : "female";
        $name = $faker->firstName($gender) . " " . $faker->lastName();
        $email = strtolower(preg_replace("|[\s.']+|", ".", $name));
        $email .= rand(0, 100) > 50 ? $faker->numberBetween(10, 99) : "";
        $email .= "@" . $faker->freeEmailDomain();
        $created = $faker->dateTimeBetween("-2 years");

        if (rand(0, 100) > 70) {
            $name = $faker->title($gender) . " " . $name;
        }

        DB::table('users')->insert([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($email),
            'created_at' => $created,
            'updated_at' => $created,
        ]);
    }
}
