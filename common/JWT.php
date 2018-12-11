<?php
/**
 * @author: jiangyi
 * @date: 下午5:53 2018/7/25
 */

namespace common;


class JWT
{

    public static function encode(array $payload, $secretKey, $alg = 'SHA256')
    {
        $jwt = self::urlsafeB64Encode(json_encode([
                'typ' => 'JWT',
                'alg' => $alg,
            ])) . '.' . self::urlsafeB64Encode(json_encode($payload));
        return $jwt . '.' . self::signature($jwt, $secretKey, $alg);
    }

    public static function decode($jwt, $secretKey)
    {
        $tokens = explode('.', $jwt);
        if (count($tokens) != 3) {
            return false;
        }

        list($header64, $payload64, $sign) = $tokens;

        $header = json_decode(self::urlsafeB64Decode($header64), true);

        if (empty($header['alg'])) {
            return false;
        }

        if (self::signature($header64 . '.' . $payload64, $secretKey, $header['alg']) !== $sign) {
            return false;
        }

        $payload = json_decode(self::urlsafeB64Decode($payload64), true);

        $time = time();
        if (isset($payload['iat']) && $payload['iat'] > $time) {
            return false;
        }

        if (isset($payload['exp']) && $payload['exp'] < $time) {
            return false;
        }

        return $payload;
    }

    public static function signature($jwt, $secretKey, $alg)
    {
        return hash_hmac($alg, $jwt, $secretKey);
    }

    public static function urlSafeB64Encode($string)
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($string));
    }

    public static function urlSafeB64Decode($string) {
        $data = str_replace(array('-','_'),array('+','/'),$string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }

}
