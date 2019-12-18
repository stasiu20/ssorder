<?php

namespace frontend\modules\apiV1\helpers;

use common\models\AccessToken;
use common\models\User;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Token;
use Lcobucci\JWT\ValidationData;

class AccessTokenHelper
{
    public const HEADER_NAME = 'Authorization';

    public static function getTokenFromHeader(string $authHeader): ?string
    {
        if (preg_match('/^Bearer\s+(.*?)$/', $authHeader, $matches)) {
            $authHeader = $matches[1];
            return $authHeader;
        }
        return null;
    }

    public static function getJwtSignKey(): string
    {
        return \Yii::$app->params['jwt_key'];
    }

    public static function createTokenForUser(User $user, int $time = null): Token
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

    public static function deleteToken(string $token): void
    {
        $accessToken = AccessToken::getByToken($token);
        if ($accessToken) {
            $accessToken->delete();
        }
    }

    public static function parseToken(string $token, string $jwtSignKey = null): ?Token
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
