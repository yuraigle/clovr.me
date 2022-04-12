<?php

namespace Database\Seeders;

use Exception;
use Faker\Factory;
use Faker\Provider\en_GB\Address;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class AdSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create("en_IE");

        $cat = $faker->randomElement([1, 2, 3, 4, 5]);

        $freq = null;
        $propType = null;
        $numBeds = null;
        $roomType = null;
        $priceW = $faker->numberBetween(15, 30) * 5;
        $priceM = $priceW * 4;
        $priceS = $priceM * 12 * 15;

        if (in_array($cat, [1, 4])) {
            $price = $priceS;
        } else {
            if (rand(0, 100) > 50) {
                $price = $priceM;
                $freq = "per_month";
            } else {
                $price = $priceW;
                $freq = "per_week";
            }
        }

        if (in_array($cat, [1, 2, 3])) {
            $propType = $faker->randomElement(["flat", "house", "other", null]);
        } elseif (in_array($cat, [4, 5])) {
            $propType = $faker->randomElement(["garage", "parking", null]);
        }

        if (in_array($cat, [1, 2])) {
            $numBeds = $faker->randomElement([0, 1, 2, 3, 5]);
        } elseif ($cat == 3) {
            $roomType = $faker->randomElement(["single", "double", "twin", "triple", "shared", "couch", null]);
        }

        if ($cat == 3) {
            $price = round($price / 2); // shared house
        } elseif (in_array($cat, [4, 5])) {
            $price = round($price / 8); // parking
        }

        $www = rand(0, 100) > 80 ? $faker->url() : null;

        if (rand(0, 100) > 50) { // Dublin
            $lng = $faker->longitude(-6.4333986, -6.1852806);
            $lat = $faker->latitude(53.2850524, 53.4115515);
        } elseif (rand(0, 100) > 50) { // Cork
            $lng = $faker->longitude(-8.5025678, -8.4031171);
            $lat = $faker->latitude(51.864161, 51.9103741);
        } else { // else Ireland
            $lng = $faker->longitude(-9.3920023, -6.356552);
            $lat = $faker->latitude(52.239418, 54.0975042);
        }

//        $addressProvider = new Address();
//        $faker->addProvider($addressProvider);

        $pics = [];
        $numPics = $faker->randomElement([0, 1, 2]);
        $imgCat = $propType == "other" ? "flat" : $propType;
        for ($i = 0; $i < $numPics; $i++) {
            $imgDim = $faker->randomElement(["800x600", "600x800", "900x900"]);
            $imgSrc = "https://source.unsplash.com/random/$imgDim/?$imgCat";
            $raw = file_get_contents($imgSrc);
            file_put_contents("1.jpg", $raw);
            $pics[] = $this->uploadImage("1.jpg");
            unlink("1.jpg");
        }

        DB::beginTransaction();

        DB::table('ads')->insert([
            'user_id' => 1,
            'category_id' => $cat,
            'title' => $faker->sentence,
            'price' => $price,
            'price_freq' => $freq,
            'property_type' => $propType,
            'num_beds' => $numBeds,
            'room_type' => $roomType,
            'description' => $faker->realText(),
            'www' => $www,
            'lng' => $lng,
            'lat' => $lat,
            'pic' => $pics ? $pics[0] : null,
            'created_at' => $faker->dateTimeBetween("-2 years"),
        ]);

        $adId = DB::getPdo()->lastInsertId();

        for ($i = 0; $i < $numPics; $i++) {
            DB::table('pictures')->insert([
                'ad_id' => $adId,
                'name' => $pics[$i],
                'ord' => $i,
            ]);
        }

        DB::commit();

        print "AD #$adId created" . PHP_EOL;
    }

    /**
     * @throws Exception
     */
    private function uploadImage($file1): string
    {
        $hash = date('ym') . substr(md5(rand()), 0, 10);
        $dest = '/' . substr($hash, 0, 4) . '/';
        $destAbs = base_path('public/images' . $dest);

        if (!file_exists($destAbs) && !mkdir($destAbs)) {
            throw new Exception('I/O exception');
        }

        Image::make($file1)->fit(200, 150)
            ->save($destAbs . "m_$hash.webp", 75);

        Image::make($file1)->fit(120, 90)
            ->save($destAbs . "s_$hash.webp", 75);

        Image::make($file1)->resize(800, 600, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })
            ->save($destAbs . "x_$hash.webp", 75);

        return $hash;
    }
}
