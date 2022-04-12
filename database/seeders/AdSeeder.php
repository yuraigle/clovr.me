<?php

namespace Database\Seeders;

use Exception;
use Faker\Factory;
use Faker\Generator;
use Faker\Provider\en_GB\Address;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class AdSeeder extends Seeder
{
    private static Generator $faker;
    private static Address $addressProvider;

    public function __construct()
    {
        self::$faker = Factory::create("en_GB");
        self::$addressProvider = new Address(self::$faker);
    }

    public function run()
    {

        $cat = self::$faker->randomElement([1, 2, 3, 4, 5]);

        $freq = null;
        $propType = null;
        $numBeds = null;
        $roomType = null;
        $priceW = self::$faker->numberBetween(15, 40) * 5;
        $priceM = $priceW * 4;
        $priceS = $priceW * 52 * 15; // price = 15 years of rent

        if (in_array($cat, [1, 4])) {
            $price = $priceS;
        } else {
            if (rand(0, 100) > 50 || in_array($cat, [4, 5])) {
                $price = $priceM;
                $freq = "per_month";
            } else {
                $price = $priceW;
                $freq = "per_week";
            }
        }

        if (in_array($cat, [1, 2, 3])) {
            $propType = self::$faker->randomElement(["flat", "house", "other", null]);
        } elseif (in_array($cat, [4, 5])) {
            $propType = self::$faker->randomElement(["garage", "parking", null]);
        }

        if (in_array($cat, [1, 2])) {
            $numBeds = self::$faker->randomElement([0, 1, 2, 3, 5]);
        } elseif ($cat == 3) {
            $roomType = self::$faker->randomElement(["single", "double", "twin", "triple", "shared", "couch", null]);
        }

        if ($cat == 3) {
            $price = round($price / 2); // shared house
        } elseif (in_array($cat, [4, 5])) {
            $price = round($price / 8); // parking
        }

        $www = rand(0, 100) > 80 ? self::$faker->url() : null;

        if (rand(0, 100) > 50) { // Dublin
            $lng = self::$faker->longitude(-6.4333986, -6.1852806);
            $lat = self::$faker->latitude(53.2850524, 53.4115515);
            $county = "Dublin";
            $town = "Dublin";
        } elseif (rand(0, 100) > 50) { // Cork
            $lng = self::$faker->longitude(-8.5025678, -8.4031171);
            $lat = self::$faker->latitude(51.864161, 51.9103741);
            $county = "Cork City";
            $town = "Cork";
        } else { // other Ireland
            $lng = self::$faker->longitude(-9.3920023, -6.356552);
            $lat = self::$faker->latitude(52.239418, 54.0975042);
            $county = self::$addressProvider::county();
            $town = self::$addressProvider->city();
        }

        if (rand(0, 100) > 30) {
            $numPics = 2;
        } elseif (rand(0, 100) > 30) {
            $numPics = 1;
        } else {
            $numPics = 0;
        }

        $imgCat = (!$propType || $propType == "other") ? "flat" : $propType;
        $cntPicsAll = DB::selectOne("SELECT count(*) as c FROM `pictures` p
                    LEFT JOIN `ads` a ON a.id = p.ad_id
                    WHERE a.property_type = ?", [$imgCat])->c;

        $pics = [];
        for ($i = 0; $i < $numPics; $i++) {
            if ($cntPicsAll < 20 || rand(0, 100) > 80) {
                $imgDim = self::$faker->randomElement(["800x600", "600x800", "900x900"]);
                $imgSrc = "https://source.unsplash.com/random/$imgDim/?$imgCat";

                try {
                    $raw = file_get_contents($imgSrc);
                    $pics[] = $this->uploadImage($raw);
                    print "Downloaded a pic: $imgCat" . PHP_EOL;
                    sleep(1);
                } catch (Exception $ignore) {
                }
            } else {
                $pics[] = DB::selectOne(
                    "SELECT p.name FROM `pictures` p LEFT JOIN `ads` a ON a.id = p.ad_id
                    WHERE a.property_type = ? ORDER BY rand() LIMIT 1", [$imgCat]
                )->name;
            }
        }

        $row = DB::selectOne("select id from `users` order by RAND() limit 1");
        $uid = $row->id;

        $hasCoords = rand(0, 100) > 10;
        $hasCounty = rand(0, 100) > 30;
        $hasTown = $hasCounty || rand(0, 100) > 30;
        $hasPostcode = rand(0, 100) > 30;
        $hasAddress = rand(0, 100) > 30;

        DB::beginTransaction();

        DB::table('ads')->insert([
            'user_id' => $uid,
            'category_id' => $cat,
            'title' => self::$faker->sentence,
            'price' => $price,
            'price_freq' => $freq,
            'property_type' => $propType,
            'num_beds' => $numBeds,
            'room_type' => $roomType,
            'description' => self::$faker->realText(),
            'www' => $www,
            'lng' => $hasCoords ? $lng : null,
            'lat' => $hasCoords ? $lat : null,
            'location' => $hasAddress ? self::$addressProvider->address() : null,
            'postcode' => $hasPostcode ? self::$addressProvider::postcode() : null,
            'county' => $hasCounty ? $county : null,
            'town' => $hasTown ? $town : null,
            'pic' => $pics ? $pics[0] : null,
            'created_at' => self::$faker->dateTimeBetween("-30 days"),
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

        print "AD #$adId created ($numPics pics)" . PHP_EOL;
    }

    /**
     * @throws Exception
     */
    private function uploadImage($raw): string
    {
        $hash = date('ym') . substr(md5(rand()), 0, 10);
        $destAbs = base_path('public/images/' . substr($hash, 0, 4) . '/');

        if (!file_exists($destAbs) && !mkdir($destAbs)) {
            throw new Exception('I/O exception');
        }

        Image::make($raw)->fit(200, 150)
            ->save($destAbs . "m_$hash.webp", 75);

        Image::make($raw)->fit(120, 90)
            ->save($destAbs . "s_$hash.webp", 75);

        Image::make($raw)->resize(800, 600, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })
            ->save($destAbs . "x_$hash.webp", 75);

        return $hash;
    }
}
