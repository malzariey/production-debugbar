<?php

namespace malzariey\ProductionDebugbar;

use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Cookie;
use Illuminate\Http\Request;

class ProductionDebugbar {
    public static function create(): Cookie
    {
        $expiresAt = Carbon::now()->addHours(12);

        return new Cookie('enable_debug', base64_encode(json_encode([
            'expires_at' => $expiresAt->getTimestamp(),
            'mac' => hash_hmac('sha256', $expiresAt->getTimestamp(), config('production-debugbar.password')),
        ])), $expiresAt, config('session.path'), config('session.domain'));
    }

    /**
     * Determine if the given Debug mode bypass cookie is valid.
     *
     * @param  string  $cookie
     * @param  string  $key
     * @return bool
     */
    public static function isValid(Request $request): bool
    {
        if(!$request->hasCookie('enable_debug')){
            return false;
        }

        $cookie = $request->cookie('enable_debug');
        $payload = json_decode(base64_decode($cookie), true);

        return is_array($payload) &&
            is_numeric($payload['expires_at'] ?? null) &&
            isset($payload['mac']) &&
            hash_equals(hash_hmac('sha256', $payload['expires_at'], config('production-debugbar.password')), $payload['mac']) &&
            (int) $payload['expires_at'] >= Carbon::now()->getTimestamp();
    }


    public static function check(?Request $request = null): bool
    {
        if (self::isValid($request ?? request())) {
            Debugbar::enable();
            return true;
        }
        return false;
    }

}
