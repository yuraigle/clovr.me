<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Intervention\Image\Facades\Image;

class AdController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function newAd()
    {
        // step 1 : details form
        return view('new-ad-details', []);
    }

    public function postAdDetails(Request $req): JsonResponse
    {
        $p = $req->post();
        // TODO backend validation
        return response()->json(["status" => "OK", "req" => $p]);
    }

    public function pictures()
    {
        return view('new-ad-upload', []);
    }


    /**
     * @throws Exception
     */
    private function uploadImage(array $file1): string
    {
        $dest = '/' . date('ym') . '/';
        $destAbs = base_path('public/images' . $dest);
        $destTmb = base_path('public/thumbnail' . $dest);
        $ext = strtolower(pathinfo($file1['name'], PATHINFO_EXTENSION));
        $newName = substr(md5(rand()), 0, 10) . '.' . $ext;

        if (!in_array($ext, ['jpg', 'png'])) {
            throw new Exception('Unexpected file type');
        }
        if (!file_exists($destAbs) && !mkdir($destAbs)) {
            throw new Exception('I/O exception');
        }
        if (!file_exists($destTmb) && !mkdir($destTmb)) {
            throw new Exception('I/O exception');
        }
        if (!move_uploaded_file($file1['tmp_name'], $destAbs . $newName)) {
            throw new Exception('I/O exception');
        }

        // resize
        $img = Image::make($destAbs . $newName);
        $img->resize(150, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $img->save($destTmb . $newName);

        return $dest . $newName;
    }

    public function upload()
    {
        reset($_FILES);
        $temp = current($_FILES);

        try {
            $pic = $this->uploadImage($temp);
        } catch (Exception $e) {
            header('HTTP/1.1 500 ' . $e->getMessage());
            die();
        }

        return json_encode(['location' => $pic]);
    }
}
