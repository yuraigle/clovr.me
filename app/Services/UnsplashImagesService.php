<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Unsplash\HttpClient as UnsplashClient;
use Unsplash\Search as UnsplashSearch;

class UnsplashImagesService
{
    private static array $cached = [];

    public function __construct()
    {
        UnsplashClient::init([
            'applicationId' => env('UNSPLASH_APP_ID'),
            'secret' => env('UNSPLASH_APP_SECRET'),
            'utmSource' => env('UNSPLASH_APP'),
        ]);
    }

    public function downloadByTag($query): string
    {
        $id = $this->getRandomIdByTag($query);
        return $this->downloadById($id);
    }

    private function searchImages($query): void
    {
        $results = UnsplashSearch::photos($query, 1, 25);

        foreach ($results->getResults() as $result) {
            self::$cached[] = [
                "id" => $result['id'],
                "url" => $result['urls']['regular'], // full ?
                "tag" => $query,
            ];
        }
    }

    private function getCachedByTag($query): array
    {
        return array_filter(self::$cached, function ($r) use ($query) {
            return $r["tag"] == $query;
        });
    }

    private function getRandomIdByTag($query): string
    {
        $arr = $this->getCachedByTag($query);

        if (!$arr) {
            $this->searchImages($query);
            $arr = $this->getCachedByTag($query);
        }

        return $arr[array_rand($arr)]["id"];
    }

    private function downloadById($imageId): string
    {
        if (!Storage::disk('local')->exists('unsplash/' . $imageId . '.jpg')) {
            $remoteUrl = array_values(array_filter(self::$cached, function ($r) use ($imageId) {
                return $r["id"] == $imageId;
            }))[0]["url"];

            Storage::putFileAs('unsplash', $remoteUrl, $imageId . '.jpg');
            print_r("Downloaded " . $imageId . PHP_EOL);
        }

        return storage_path('app/unsplash/' . $imageId . '.jpg'); //
    }


}
