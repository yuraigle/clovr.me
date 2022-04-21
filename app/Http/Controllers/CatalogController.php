<?php

namespace App\Http\Controllers;

use App\Helpers\AdUrl;
use App\Services\LocationService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class CatalogController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected LocationService $locationService;

    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }

    public function showAd(Request $req)
    {
        $id = $req->route()->parameter('id') - AdUrl::$PROJECT_STARTED_TS;

        $rowAd = DB::selectOne("select * from `ads` where `id`=?", [$id]);
        abort_if(!$rowAd, 404);

        $rowUsr = DB::selectOne("select * from `users` where `id`=?", [$rowAd->user_id]);
        abort_if(!$rowUsr, 404);

        $pics = DB::select("select * from `pictures` where `ad_id`=? order by `ord`", [$id]);

        return view('catalog.show-ad', ["ad" => $rowAd, "usr" => $rowUsr, "pics" => $pics]);
    }

    public function showCat($cat, Request $req)
    {
        $cid = array_search($cat, AdUrl::$CATS);
        abort_if(!$cid, 404);

        $rowCat = DB::selectOne("select * from `categories` where `id`=?", [$cid]);
        abort_if(!$rowCat, 404);

        $adsPerPage = 15;
        $currentPage = $req->query('page', 1);
        $offset = ($currentPage - 1) * $adsPerPage;

        $town = $this->locationService->getTown(); // TODO: filter by town

        $rowCnt = DB::selectOne("select count(*) as c from `ads` where `category_id`=?", [$cid]);
        $totalAds = $rowCnt->c;
        $totalPages = ceil($totalAds / $adsPerPage);

        $rows = DB::select("select * from `ads` where `category_id`=?
            order by `created_at` desc limit ? offset ?", [$cid, $adsPerPage, $offset]);

        $paginator = new LengthAwarePaginator($rows, $totalAds, $adsPerPage, $currentPage);
        $paginator::useBootstrap();
        $paginator->setPath("");

        return view('catalog.show-cat', [
            'town' => $town,
            'cat' => $rowCat,
            'paginator' => $paginator,
        ]);
    }
}
