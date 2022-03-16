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
use Intervention\Image\Facades\Image;

class AdController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function newAd()
    {
        return view('new-ad', []);
    }

    public function postAd(Request $req): JsonResponse
    {
        $p = $req->post();
        // TODO backend validation
        return response()->json(["status" => "OK", "req" => $p]);
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
        $hash = substr(md5(rand()), 0, 10);
        $dest = '/' . substr($hash, 0, 2) . '/';
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
