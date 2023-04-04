<?php

use Illuminate\Support\Facades\Cache;
use Magarrent\LaravelUrlShortener\Models\UrlShortener;

$shortUrls = Cache::tags(['urlShortener'])
    ->rememberForever('urlShortenerAll', function () {
        return UrlShortener::all();
    });

foreach ($shortUrls as $url) {
    Route::redirect($url->url_key, $url->to_url, 301);
}
