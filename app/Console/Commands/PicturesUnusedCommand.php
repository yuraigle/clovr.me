<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PicturesUnusedCommand extends Command
{
    protected $signature = 'pictures:unused';
    protected $description = 'Remove unused pictures from public/images';

    public function handle()
    {
        $adPictures = DB::select("select `name` from `pictures`");
        $userPictures = DB::select("select `pic` from `users`");

        $files = Storage::disk('images')->allFiles();
        foreach ($files as $file) {
            if (preg_match("/.*([0-9]{4}[0-9a-f]{10}).*\.(jpg|webp)$/", $file, $m)) {
                $hash = $m[1];
                $existsAd = array_filter($adPictures, function ($p) use ($hash) {
                    return $p->name == $hash;
                });
                $existsUser = array_filter($userPictures, function ($p) use ($hash) {
                    return $p->pic == $hash;
                });
                if (!$existsAd && !$existsUser) {
                    Storage::disk('images')->delete($file);
                    print_r("Deleted: $file" . PHP_EOL);
                }
            } else {
                print_r("warn: " . $file . PHP_EOL);
            }
        }

        echo("Done" . PHP_EOL);
    }
}
