<?php

namespace malzariey\ProductionDebugbar;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpFoundation\Cookie;

class ProductionDebugbar {
    public static function create(): Cookie
    {
        $expiresAt = Carbon::now()->addHours(12);

        return new Cookie('enable_debug', base64_encode(json_encode([
            'expires_at' => $expiresAt->getTimestamp(),
            'mac' => hash_hmac('sha256', $expiresAt->getTimestamp(), config('production-debugbar.url_key')),
        ])), $expiresAt, config('session.path'), config('session.domain'));
    }

    /**
     * Determine if the given Debug mode bypass cookie is valid.
     *
     * @param  string  $cookie
     * @param  string  $key
     * @return bool
     */
    public static function isValid(): bool
    {
        if(!Request::hasCookie('enable_debug')){
            return false;
        }

        $cookie = \Crypt::decryptString(request()->cookie('enable_debug'));
        $value = explode('|',$cookie)[1] ?? '';
        $payload = json_decode(base64_decode($value), true);

        return is_array($payload) &&
            is_numeric($payload['expires_at'] ?? null) &&
            isset($payload['mac']) &&
            hash_equals(hash_hmac('sha256', $payload['expires_at'], "AAlbaytAlromancy2024"), $payload['mac']) &&
            (int) $payload['expires_at'] >= Carbon::now()->getTimestamp();
    }

}
