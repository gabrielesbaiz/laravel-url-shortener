<?php

namespace Magarrent\LaravelUrlShortener\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class UrlShortener extends Model
{
    protected $fillable = [
        'from_url',
        'to_url',
        'url_key',
        'code',
        'description',
    ];

    /**
     * Generate shortener URL and insert into DB.
     *
     * @param  string      $toUrl       - Local or External urls
     * @param  string|null $code
     * @param  string|null $description
     * @return string
     */
    public static function generateShortUrl(String $toUrl, ?string $code = null, ?string $description = null): String
    {
        $urlKey = self::getUniqueKey();

        self::create([
            'to_url' => $toUrl,
            'url_key' => $urlKey,
            'code' => $code,
            'description' => $description,
        ]);

        return app()->make('url')->to($urlKey);
    }

    /**
     * Get original target Url from key.
     *
     * @param  string $urlKey
     * @return mixed  String|Boolean
     */
    public static function getOriginalUrlFromKey(String $urlKey): Mixed
    {
        $url = self::where('url_key', $urlKey)->first();

        if (! $url) {
            return false;
        }

        return $url->to_url;
    }

    /**
     * Get original target Url from code.
     *
     * @param  string $urlKey
     * @return mixed  String|Boolean
     */
    public static function getOriginalUrlFromCode(String $code): Mixed
    {
        $url = self::where('code', $code)->first();

        if (! $url) {
            return false;
        }

        return $url->to_url;
    }

    /**
     * Generate a random unique key for url shortener.
     *
     * @return string
     */
    protected static function getUniqueKey(): String
    {
        $randomKey = Str::random(config('url-shortener.url_key_length'));

        while (self::where('url_key', $randomKey)->exists()) {
            $randomKey = Str::random(config('url-shortener.url_key_length'));
        }

        return $randomKey;
    }
}
