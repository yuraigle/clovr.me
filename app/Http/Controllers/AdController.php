<?php

namespace App\Http\Controllers;

use App\Services\LocationService;
use App\Services\UploaderService;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class AdController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected LocationService $locationService;
    protected UploaderService $uploaderService;

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
        'location' => 'required|string|min:5|max:250',
        'postcode' => 'nullable|string|max:10',
        'county' => 'nullable|string|max:50',
        'town' => 'nullable|string|max:100',
        'pictures' => 'nullable|array|max:10',
        'pictures.*' => 'required|string|regex:/^[0-9a-f]{14}$/',
    ];

    /**
     * @param LocationService $locationService
     * @param UploaderService $uploaderService
     */
    public function __construct(
        LocationService $locationService,
        UploaderService $uploaderService
    )
    {
        $this->locationService = $locationService;
        $this->uploaderService = $uploaderService;
    }


    public function newAd(): RedirectResponse|View
    {
        if (!Auth::check()) {
            return redirect('/login?back=' . urlencode(route('new-ad', [], false)));
        }

        return view('member.new-ad', [
            "town" => $this->locationService->getTownFromCookie()
        ]);
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

        return response()->json(["result" => "OK", "id" => $adId]);
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

    public function editAd($id): RedirectResponse|View
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $row = DB::selectOne("select * from `ads` where id=?", [$id]);
        abort_if(!$row, 404, "Ad not found");

        $pics = DB::select("select * from `pictures` where ad_id=? order by ord", [$id]);
        $row->pictures = $pics;

        return view('member.edit-ad', [
            "row_json" => json_encode($row),
            "town" => $this->locationService->getTownFromCookie(),
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
        DB::update(
            "update `ads` set `title`=?, `price`=?, `property_type`=?, `num_beds`=?,
                   `price_freq`=?, `date_avail`=?, `room_type`=?, `room_couples`=?, `www`=?,
                   `youtube`=?, `description`=?, `lng`=?, `lat`=?, `location`=?, `postcode`=?,
                    `county`=?, `town`=?, `pic`=? where `id`=?",
            [...$vars, $pic, $id]
        );

        $i = 0;
        DB::delete("delete from `pictures` where `ad_id`=?", [$id]);
        foreach ($pictures as $name) {
            DB::insert(
                "insert into `pictures` (`ad_id`, `name`, `ord`) values (?,?,?)",
                [$id, $name, $i++]
            );
        }
        DB::commit();

        return response()->json(["result" => "OK", "id" => $id]);
    }

    public function upload(Request $req): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json(["message" => "Unauthenticated"], 401);
        }

        try {
            $hash = $this->uploaderService->uploadImage($req->file('pic'));
            return response()->json(["result" => "OK", "hash" => $hash]);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

}
