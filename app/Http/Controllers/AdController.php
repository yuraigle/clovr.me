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
            $pic = $this->uploadImage($req->file('pic'));
            return response()->json(['location' => $pic]);
        } catch (Exception $e) {
            return abort(500, $e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    private function uploadImage(UploadedFile $file1): string
    {
        $dest = '/' . date('ym') . '/';
        $destAbs = base_path('public/images' . $dest);
        $ext = strtolower($file1->extension());
        $newName = substr(md5(rand()), 0, 10) . '.' . $ext;

        if (!in_array($ext, ['jpg', 'png'])) {
            throw new Exception('Unexpected file type');
        }
        if (!file_exists($destAbs) && !mkdir($destAbs)) {
            throw new Exception('I/O exception');
        }

        Image::make($file1)->fit(200, 150)->save($destAbs . "m_" . $newName);
        Image::make($file1)->fit(120, 90)->save($destAbs . "s_" . $newName);
        $file1->move($destAbs, "x_" . $newName);

        return $dest . "x_" . $newName;
    }
}
