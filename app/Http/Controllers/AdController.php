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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class AdController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private array $rules = [
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
        'lng' => 'nullable|regex:/^\-?[0-9]{1,3}\.[0-9]{0,20}$/',
        'lat' => 'nullable|regex:/^\-?[0-9]{1,3}\.[0-9]{0,20}$/',
        'location' => 'required|string|max:250',
        'postcode' => 'nullable|string|max:10',
        'county' => 'nullable|string|max:50',
        'town' => 'nullable|string|max:100',
        'pictures' => 'nullable|array|max:10',
        'pictures.*' => 'required|string|regex:/^[0-9a-f]{14}$/',
    ];

    public function newAd()
    {
        if (!Auth::check()) {
            return redirect('/login?back=new-ad');
        }

        return view('member.new-ad', []);
    }

    public function newAdPost(Request $req): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json(["message" => "Unauthenticated"], 401);
        }

        $userId = $req->user()->id;

        $validator = Validator::make($req->post(), $this->rules);
        try {
            $validator->validate();
            $v = $validator->validated();
        } catch (Exception $e) {
            return response()->json(["message" => $validator->errors()->first()], 400);
        }

        $v = $this->sanitize($v, $v['category_id']);
        $pictures = $req->post('pictures', []);
        $pic = $pictures ? $pictures[0] : null;

        $fields = [
            'title', 'price', 'property_type', 'num_beds', 'price_freq',
            'date_avail', 'room_type', 'room_couples', 'www', 'youtube', 'description',
            'lng', 'lat', 'location', 'postcode', 'county', 'town', 'category_id'
        ];
        $vars = [];
        foreach ($fields as $field) {
            $vars[] = $v[$field] ?? null;
        }

        DB::beginTransaction();
        DB::insert(
            "insert into `ads` (`title`, `price`, `property_type`, `num_beds`, `price_freq`,
                   `date_avail`, `room_type`, `room_couples`, `www`, `youtube`, `description`,
                   `lng`, `lat`, `location`, `postcode`, `county`, `town`, `category_id`, `pic`,
                   `user_id`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
            [...$vars, $pic, $userId]
        );

        $adId = DB::getPdo()->lastInsertId();
        $i = 0;
        foreach ($pictures as $name) {
            DB::insert(
                "insert into `pictures` (`ad_id`, `name`, `ord`) values (?,?,?)",
                [$adId, $name, $i++]
            );
        }
        DB::commit();

        return response()->json(["status" => "OK", "id" => $adId]);
    }

    private function sanitize(array $v, int $cid): array
    {
        if (!in_array($cid, [2, 3, 5])) {
            $v['price_freq'] = null;
        }
        if (!in_array($cid, [1, 2])) {
            $v['num_beds'] = null;
        }
        if ($cid != 3) {
            $v['room_type'] = null;
        }
        return $v;
    }

    public function editAd($id)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $row = DB::selectOne("select * from `ads` where id=?", [$id]);
        $pics = DB::select("select * from `pictures` where ad_id=? order by ord", [$id]);
        $row->pictures = $pics;
        abort_if(!$row, 404, "Ad not found");

        return view('member.edit-ad', [
            "row_json" => json_encode($row),
        ]);
    }

    public function editAdPost(Request $req): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json(["message" => "Unauthenticated"], 401);
        }

        $id = $req->route()->parameter('id');
        $uid = $req->user()->id;

        $rowAd = DB::selectOne("select * from `ads` where `id`=?", [$id]);
        if (!$rowAd || $rowAd->user_id !== $uid) {
            return response()->json(["message" => "Unauthenticated"], 401);
        }

        $validator = Validator::make($req->post(), $this->rules);
        try {
            $validator->validate();
            $v = $validator->validated();
        } catch (Exception $e) {
            return response()->json(["message" => $validator->errors()->first()], 400);
        }

        $v = $this->sanitize($v, $rowAd->category_id);
        $pictures = $req->post('pictures', []);
        $pic = $pictures ? $pictures[0] : null;

        $fields = [
            'title', 'price', 'property_type', 'num_beds', 'price_freq',
            'date_avail', 'room_type', 'room_couples', 'www', 'youtube', 'description',
            'lng', 'lat', 'location', 'postcode', 'county', 'town'
        ];
        $vars = [];
        foreach ($fields as $field) {
            $vars[] = $v[$field] ?? null;
        }

        DB::beginTransaction();
        DB::insert(
            "update `ads` set `title`=?, `price`=?, `property_type`=?, `num_beds`=?,
                   `price_freq`=?, `date_avail`=?, `room_type`=?, `room_couples`=?, `www`=?,
                   `youtube`=?, `description`=?, `lng`=?, `lat`=?, `location`=?, `postcode`=?,
                    `county`=?, `town`=?, `pic`=? where `id`=?",
            [...$vars, $pic, $id]
        );

        $a = [...$vars, $pic, $id];

        $i = 0;
        DB::delete("delete from `pictures` where `ad_id`=?", [$id]);
        foreach ($pictures as $name) {
            DB::insert(
                "insert into `pictures` (`ad_id`, `name`, `ord`) values (?,?,?)",
                [$id, $name, $i++]
            );
        }
        DB::commit();

        return response()->json(["status" => "OK", "id" => $id]);
    }

    public function upload(Request $req): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json(["message" => "Unauthenticated"], 401);
        }

        try {
            $hash = $this->uploadImage($req->file('pic'));
            return response()->json(["status" => "OK", "hash" => $hash]);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
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
