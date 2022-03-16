<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class AdController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function newAd()
    {
        return view('new-ad', []);
    }

    // TODO: authenticated
    public function postAd(Request $req): JsonResponse
    {
        $validator = Validator::make($req->post(), [
            'category_id' => 'required|numeric|min:1|max:5',
            'title' => 'required|string|max:100',
            'price' => 'required|regex:/^[0-9]*(\.[0-9]{1,2})?$/',
            'property_type' => 'nullable|regex:/^[a-z]{0,10}$/',
            'num_beds' => 'nullable|numeric|max:10',
            'price_freq' => 'nullable|in:per_month,per_week',
            'date_avail' => 'nullable',
            'room_type' => 'nullable|regex:/^[a-z]{0,10}$/',
            'room_couples' => 'nullable|numeric|min:0|max:1',
            'www' => 'nullable|url|max:500',
            'youtube' => 'nullable|url|max:100|regex:/^https?:\/\/(www\.)?youtube\.com\/watch/',
            'description' => 'required|string|max:10000',
            'postcode' => 'nullable|string|max:10',
            'county' => 'nullable|string|max:20',
            'town' => 'nullable|string|max:30',
            'street' => 'nullable|string|max:50',
            'lng' => 'nullable|regex:/^\-?[0-9]{1,3}\.[0-9]{0,20}$/',
            'lat' => 'nullable|regex:/^\-?[0-9]{1,3}\.[0-9]{0,20}$/',
            'pictures' => 'nullable|array|max:10',
            'pictures.*' => 'required|string|regex:/^[0-9a-f]{14}$/',
        ]);

        try {
            $validator->validate();
        } catch (Exception $e) {
            return response()->json([
                "status" => "FAIL",
                "messages" => $validator->errors(),
            ]);
        }

        $userId = 0;
        $categoryId = $req->post('category_id');
        $title = $req->post('title');
        $price = $req->post('price');
        $propertyType = $req->post('property_type');
        $numBeds = $req->post('num_beds');
        $priceFreq = $req->post('price_freq');
        $dateAvail = $req->post('date_avail');
        $roomType = $req->post('room_type');
        $roomCouples = $req->post('room_couples');
        $www = $req->post('www');
        $youtube = $req->post('youtube');
        $description = $req->post('description');
        $postcode = $req->post('postcode');
        $county = $req->post('county');
        $town = $req->post('town');
        $street = $req->post('street');
        $lng = $req->post('lng');
        $lat = $req->post('lat');
        $pictures = $req->post('pictures', []);

        DB::beginTransaction();
        DB::insert("insert into `ads` (`user_id`, `category_id`, `title`, `price`, `property_type`,
                   `num_beds`, `price_freq`, `date_avail`, `room_type`, `room_couples`, `www`,
                   `youtube`, `description`, `postcode`, `county`, `town`, `street`, `lng`, `lat`)
                    values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
            [
                $userId, $categoryId, $title, $price, $propertyType, $numBeds, $priceFreq,
                $dateAvail, $roomType, $roomCouples, $www, $youtube, $description, $postcode,
                $county, $town, $street, $lng, $lat
            ]
        );

        $adId = DB::getPdo()->lastInsertId();
        $i = 0;
        foreach ($pictures as $name) {
            DB::insert("insert into `pictures` (`ad_id`, `name`, `ord`) values (?,?,?)",
                [$adId, $name, $i++]);
        }
        DB::commit();

        return response()->json(["status" => "OK", "id" => $adId]);
    }

    public function upload(Request $req)
    {
        try {
            $hash = $this->uploadImage($req->file('pic'));
            return response()->json(['hash' => $hash]);
        } catch (Exception $e) {
            return abort(500, $e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    private function uploadImage(UploadedFile $file1): string
    {
        $hash = date('ym') . substr(md5(rand()), 0, 10);
        $dest = '/' . substr($hash, 0, 4) . '/';
        $destAbs = base_path('public/images' . $dest);

        if (!file_exists($destAbs) && !mkdir($destAbs)) {
            throw new Exception('I/O exception');
        }

        Image::make($file1)->fit(200, 150)
            ->save($destAbs . "m_$hash.jpg")
            ->save($destAbs . "m_$hash.webp", 75);

        Image::make($file1)->fit(120, 90)
            ->save($destAbs . "s_$hash.jpg")
            ->save($destAbs . "s_$hash.webp", 75);

        Image::make($file1)->resize(800, 600, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })
            ->save($destAbs . "x_$hash.jpg")
            ->save($destAbs . "x_$hash.webp", 75);

        return $hash;
    }
}
