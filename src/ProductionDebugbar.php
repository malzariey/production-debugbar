<?php

namespace malzariey\ProductionDebugbar;

use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Cookie;

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
    public static function isValid(): bool
    {
        if(!\Request::hasCookie('enable_debug')){
            return false;
        }
        try {
            $cookie = \Crypt::decryptString(request()->cookie('enable_debug'));
            $value = explode('|',$cookie)[1] ?? '';
            $payload = json_decode(base64_decode($value), true);
        }catch (\Exception $exception){
            $cookie = request()->cookie('enable_debug');
            $payload = json_decode(base64_decode($cookie), true);
        }

        return is_array($payload) &&
            is_numeric($payload['expires_at'] ?? null) &&
            isset($payload['mac']) &&
            hash_equals(hash_hmac('sha256', $payload['expires_at'], config('production-debugbar.password')), $payload['mac']) &&
            (int) $payload['expires_at'] >= Carbon::now()->getTimestamp();
    }


    public static function check(): bool
    {
        if (self::isValid()) {
            Debugbar::enable();
            return true;
        }
        return false;
    }

}
