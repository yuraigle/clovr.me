<?php

namespace App\Services;

use Exception;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;

class UploaderService
{
    /**
     * @throws Exception
     */
    public function uploadImage(UploadedFile $file1, $ratio = "4:3"): string
    {
        if ($file1->getSize() > 4 * 1024 * 1024) {
            throw new Exception('Maximum file size to upload is 4MB');
        }

        $ratioX = 4;
        $ratioY = 3; // 4:3 by default
        if ($ratio && preg_match("|^(\d+):(\d+)$|", $ratio, $m)) {
            $ratioX = $m[1];
            $ratioY = $m[2];
        }

        $hash = date('ym') . substr(md5(rand()), 0, 10);
        $dest = '/' . substr($hash, 0, 4) . '/';
        $destAbs = base_path('public/images' . $dest);

        if (!file_exists($destAbs) && !mkdir($destAbs)) {
            throw new Exception('I/O exception');
        }

        Image::make($file1)->fit(200, 200 * $ratioY / $ratioX)
            ->save($destAbs . "m_$hash.jpg")
            ->save($destAbs . "m_$hash.webp", 75);

        Image::make($file1)->fit(120, 120 * $ratioY / $ratioX)
            ->save($destAbs . "s_$hash.jpg")
            ->save($destAbs . "s_$hash.webp", 75);

        Image::make($file1)->resize(800, 800 * $ratioY / $ratioX, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })
            ->save($destAbs . "x_$hash.jpg")
            ->save($destAbs . "x_$hash.webp", 75);

        return $hash;
    }
}
