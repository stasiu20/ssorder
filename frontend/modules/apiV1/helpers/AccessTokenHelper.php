<?php

namespace frontend\modules\apiV1\helpers;

use common\models\User;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\ValidationData;

class AccessTokenHelper
{
    const HEADER_NAME = 'Authorization';

    public static function getTokenFromHeader($authHeader)
    {
        if (preg_match('/^Bearer\s+(.*?)$/', $authHeader, $matches)) {
            $authHeader = $matches[1];
            return $authHeader;
        }
        return null;
    }

    public static function getJwtSignKey()
    {
        return \Yii::$app->params['jwt_key'];
    }

    public static function createTokenForUser(User $user, $time = null)
    {
        if (null === $time) {
            $time = time();
        }
        $signer = new Sha256();
        $token = (new Builder())
            ->issuedAt($time) // Configures the time that the token was issue (iat claim)
            ->expiresAt($time + 3600) // Configures the expiration time of the token (exp claim)
            ->withClaim('uid', $user->getId()) // Configures a new claim, called "uid"
            ->getToken($signer, new Key(self::getJwtSignKey())); // Retrieves the generated token

        return $token;
    }

    public static function parseToken($token, $jwtSignKey = null)
    {
        if (null === $jwtSignKey) {
            $jwtSignKey = self::getJwtSignKey();
        }

        try {
            $token = (new Parser())->parse($token);
            $isSignValid = $token->verify(new Sha256(), $jwtSignKey);
            $isValid = $token->validate(new ValidationData());
            if ($isSignValid && $isValid) {
                return $token;
            }
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }
}
