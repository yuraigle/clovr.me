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
    public function uploadImage(UploadedFile $file1): string
    {
        if ($file1->getSize() > 4 * 1024 * 1024) {
            throw new Exception('Maximum file size to upload is 4MB');
        }

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
