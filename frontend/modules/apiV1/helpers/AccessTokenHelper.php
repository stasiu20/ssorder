<?php

namespace frontend\modules\apiV1\helpers;

use common\models\AccessToken;
use common\models\User;
use DateTimeImmutable;
use Exception;
use Lcobucci\Clock\SystemClock;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Token;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Lcobucci\JWT\Validation\Constraint\ValidAt;
use Ramsey\Uuid\Uuid;

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
            $now = new DateTimeImmutable();
        } else {
            $now = DateTimeImmutable::createFromFormat('U', $time);
        }

        $config = Configuration::forSymmetricSigner(new Sha256(), InMemory::plainText(self::getJwtSignKey()));
        $uuid = Uuid::uuid4();

        return $config->builder()
            ->identifiedBy($uuid)
            ->withHeader('jti', $uuid->toString())
            ->issuedAt($now)
            ->expiresAt($now->modify('+1 hour'))
            ->withClaim('uid', $user->id)
            ->getToken($config->signer(), $config->signingKey());
    }

    public static function deleteToken(string $token): void
    {
        $accessToken = AccessToken::getByToken($token);
        if ($accessToken) {
            $accessToken->delete();
        }
    }

    public static function parseToken(string $jwt, string $jwtSignKey = null): ?Token
    {
        if (null === $jwtSignKey) {
            $jwtSignKey = self::getJwtSignKey();
        }

        $config = Configuration::forSymmetricSigner(new Sha256(), InMemory::plainText($jwtSignKey));
        $config->setValidationConstraints(
            new SignedWith($config->signer(), $config->signingKey()),
            new ValidAt(SystemClock::fromSystemTimezone())
        );

        try {
            $token = $config->parser()->parse($jwt);
            if ($config->validator()->validate($token, ...$config->validationConstraints())) {
                return $token;
            }
        } catch (Exception $e) {
            return null;
        }

        return null;
    }
}
