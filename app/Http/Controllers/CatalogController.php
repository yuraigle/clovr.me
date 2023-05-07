<?php

namespace App\Http\Controllers;

use App\Helpers\AdUrl;
use App\Services\LocationService;
use App\Services\RecommendationsService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class CatalogController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected LocationService $locationService;
    private RecommendationsService $recommendationsService;

    public function __construct(
        LocationService        $locationService,
        RecommendationsService $recommendationsService
    )
    {
        $this->locationService = $locationService;
        $this->recommendationsService = $recommendationsService;
    }

    public function home(Request $req): View|RedirectResponse
    {
        if ($loc = $req->query("loc")) {
            $isCorrect = $this->locationService->getTownByName($loc);
            $loc = $isCorrect ? urlencode($loc) : "Dublin";
            return redirect('/')->withCookie(cookie("location", $loc, 60 * 24 * 10));
        }

        $featured = DB::select("select * from `ads` where `pic` is not null limit 6");

        return view('catalog.home', [
            "towns" => $this->locationService->getTowns(),
            "town" => $this->locationService->getTownFromCookie()->getName(),
            "featured" => $featured,
        ]);
    }

    public function showAd(Request $req): View
    {
        $id = $req->route()->parameter('id');
        $ad = DB::selectOne("select * from `ads` where `id`=?", [$id]);
        abort_if(!$ad, 404);

        $cat = DB::selectOne("select * from `categories` where `id`=?", [$ad->category_id]);
        abort_if(!$cat, 404);

        $usr = DB::selectOne("select * from `users` where `id`=?", [$ad->user_id]);
        abort_if(!$usr, 404);

        $pics = DB::select("select * from `pictures` where `ad_id`=? order by `ord`", [$id]);

        $town = $this->locationService->getTownFromCookie()->getName();
        $also = $this->recommendationsService->fetchForAd($ad, 20);

        return view('catalog.show-item', compact("ad", "cat", "usr", "pics", "town", "also"));
    }

    public function showCat(Request $req, $cat, $propType = null): View
    {
        $cid = array_search($cat, AdUrl::$CATS);
        abort_if(!$cid, 404);

        $rowCat = DB::selectOne("select * from `categories` where `id`=?", [$cid]);
        abort_if(!$rowCat, 404);

        $perPage = 15;
        $currentPage = $req->query('page', 1);
        $offset = ($currentPage - 1) * $perPage;

        $cond = "`category_id` = ?";
        $vars = [$cid];

        if ($propType) {
            $cond .= " and `property_type` = ?";
            $vars[] = $propType;
        }

        $town = $this->locationService->getTownFromCookie()->getName();
        // todo: +filter by town

        $rowCnt = DB::selectOne("select count(*) as c from `ads` where $cond", $vars);

        $rows = DB::select("
            select a.`id`, category_id, title, price, price_freq, location, county, town, postcode,
                   pic, created_at, description, property_type, num_beds, room_type, count(p.id) as npic
            from `ads` a
                left join `pictures` p on p.ad_id = a.id
            where $cond
            group by a.id, category_id, title, price, price_freq, location, county, town, postcode,
                pic, created_at, description, property_type, num_beds, room_type
            order by created_at desc limit ? offset ?", [...$vars, $perPage, $offset]);

        $paginator = new LengthAwarePaginator($rows, $rowCnt->c, $perPage, $currentPage,
            ["path" => ""]);
        $paginator::useBootstrap();

        return view('catalog.show-cat', [
            'paginator' => $paginator,
            'cat' => $rowCat,
            'propType' => $propType,
            'town' => $town,
        ]);
    }

    public function search(Request $req): View|RedirectResponse
    {
        return view('catalog.search', [
            "town" => $this->locationService->getTownFromCookie(),
        ]);
    }

    public function markers(Request $req): JsonResponse
    {
        $rows = DB::select("select `id`, `category_id`, `title`, `price`, `price_freq`, `pic`, `lat`, `lng` from `ads`
                            where `lat` is not null and `lng` is not null");

        $features = [];
        foreach ($rows as $row) {
            $features[] = [
                "type" => "Feature",
                "geometry" => [
                    "type" => "Point",
                    "coordinates" => [$row->lng, $row->lat],
                ],
                "properties" => [
                    "id" => $row->id,
                    "title" => $row->title,
                    "price" => $row->price,
                    "price_freq" => $row->price_freq,
                    "pic" => $row->pic,
                    "url" => AdUrl::canonical($row),
                ],
                "id" => $row->id,
            ];
        }

        return response()->json(["type" => "FeatureCollection", "features" => $features]);
    }
}
