<?php

namespace Database\Seeders;

use App\Services\LocationService;
use Exception;
use Faker\Factory;
use Faker\Generator;
use Faker\Provider\en_GB\Address;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Seeder;
use Illuminate\Http\Request;
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
            $roomType = self::$faker->randomElement(
                ["single", "double", "twin", "triple", "shared", "couch", null]
            );
        }

        if ($cat == 3) {
            $price = round($price / 2); // shared house
        } elseif (in_array($cat, [4, 5])) {
            $price = round($price / 8); // parking
        }

        $www = rand(0, 100) > 80 ? self::$faker->url() : null;

        $location = new LocationService(Request::capture());
        $towns = $location->getTowns();
        $townObj = $towns[8];
        for ($i = 0; $i < count($towns); $i++) {
            if (rand(0, 100) > 55) {
                $townObj = $towns[$i];
                break;
            }
        }

        if ($townObj->getZoom() == 11) {
            $dY = .05;
        } elseif ($townObj->getZoom() == 12) {
            $dY = .025;
        } else {
            $dY = .015;
        }

        $dX = $dY * 2;
        $centerLng = floatval($townObj->getLng());
        $centerLat = floatval($townObj->getLat());

        $lng = self::$faker->longitude($centerLng - $dX, $centerLng + $dX);
        $lat = self::$faker->latitude($centerLat - $dY, $centerLat + $dY);
        $county = "";
        $town = "";
        $postcode = "";
        $location = "";

        try {
            $client = new Client(['verify' => false]);
            $url = "https://api.mapbox.com/geocoding/v5/mapbox.places/$lng,$lat.json";
            $resp = $client->request('GET', $url, [
                'query' => ['access_token' => env('MAPBOX_PK')]
            ]);

            $json = $resp->getBody()->getContents();
            $data = json_decode($json, true);

            foreach ($data['features'] as $f) {
                $id = preg_replace('|[.].*|', '', $f['id']);
                $text = $f['text'] ?: '';

                if ($id == 'region') {
                    $county = $text;
                } elseif ($id == 'place') {
                    $town = $text;
                } elseif ($id == 'postcode') {
                    $postcode = $text;
                } elseif ($id == 'address') {
                    $addr = !empty($f['address']) ? $f['address'] : '';
                    $location = trim($addr . ' ' . $text);
                } elseif ($id == 'poi') {
                    $location = trim($text);
                }
            }
        } catch (Exception|GuzzleException $ignore) {
        }

        if (!$location) {
            $location = self::$addressProvider->address();
        }

        if (!$postcode) {
            $postcode = self::$addressProvider::postcode();
        }

        $numPics = self::$faker->numberBetween(0, 6);
        $pics = [];
        for ($i = 0; $i < $numPics; $i++) {
            if (in_array($propType, ["garage", "parking"])) {
                $imgCat = "garage";
            } elseif (in_array($propType, ["flat", "other"])) {
                $imgCat = "flat";
            } else {
                $imgCat = "house";
            }
            $imgNum = self::$faker->randomElement([1, 2, 3]);
            $imgSrc = "dist/img/$imgCat$imgNum.jpg";

            try {
                $raw = file_get_contents($imgSrc);
                $pics[] = $this->uploadImage($raw);
            } catch (Exception $e) {
                print_r($e->getMessage());
            }
        }

        $row = DB::selectOne("select id from `users` order by RAND() limit 1");
        $uid = $row->id;

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
            'lng' => $lng,
            'lat' => $lat,
            'location' => $location,
            'postcode' => $postcode,
            'county' => $county ?: null,
            'town' => $town,
            'pic' => $pics ? $pics[0] : null,
            'created_at' => self::$faker->dateTimeBetween("-30 days"),
        ]);

        $adId = DB::getPdo()->lastInsertId();

        for ($i = 0; $i < count($pics); $i++) {
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
