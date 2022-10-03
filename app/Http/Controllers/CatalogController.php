<?php

namespace App\Http\Controllers;

use App\Helpers\AdUrl;
use App\Services\LocationService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class CatalogController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected LocationService $locationService;

    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }

    public function showAd(Request $req): View
    {
        $id = $req->route()->parameter('id');
        $rowAd = DB::selectOne("select * from `ads` where `id`=?", [$id]);
        abort_if(!$rowAd, 404);

        $rowCat = DB::selectOne("select * from `categories` where `id`=?", [$rowAd->category_id]);
        abort_if(!$rowCat, 404);

        $rowUsr = DB::selectOne("select * from `users` where `id`=?", [$rowAd->user_id]);
        abort_if(!$rowUsr, 404);

        $pics = DB::select("select * from `pictures` where `ad_id`=? order by `ord`", [$id]);

        $town = $this->locationService->getTown();

        return view('catalog.show-ad', [
            "ad" => $rowAd,
            "cat" => $rowCat,
            "usr" => $rowUsr,
            "pics" => $pics,
            'propType' => $rowAd->property_type,
            "town" => $town,
        ]);
    }

    public function showCat(Request $req, $cat, $propType = null): View
    {
        $cid = array_search($cat, AdUrl::$CATS);
        abort_if(!$cid, 404);

        $rowCat = DB::selectOne("select * from `categories` where `id`=?", [$cid]);
        abort_if(!$rowCat, 404);

        $town = $this->locationService->getTown();

        $perPage = 15;
        $currentPage = $req->query('page', 1);
        $offset = ($currentPage - 1) * $perPage;

        $cond = "`category_id` = ?";
        $vars = [$cid];

        if ($propType) {
            $cond .= " and `property_type` = ?";
            $vars[] = $propType;
        }

        // TODO: +filter by town

        $rowCnt = DB::selectOne("select count(*) as c from `ads` where $cond", $vars);

        $rows = DB::select("select `id`, `category_id`, `title`, `price`, `price_freq`, `location`,
                `pic`, `created_at`, `description`
            from `ads` where $cond
            order by `created_at` desc limit ? offset ?", [...$vars, $perPage, $offset]);

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
        return view('catalog.search', []);
    }
}
