<?php

namespace frontend\tests\unit\modules\apiV1\helpers;

use Codeception\Test\Unit;
use common\models\User;
use frontend\modules\apiV1\helpers\AccessTokenHelper;
use Lcobucci\JWT\Token;

class AccessTokenHelperTest extends Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;

    public function testCreateTokenForUser()
    {
        $user = new User();
        $user->id = 12;

        $token = AccessTokenHelper::createTokenForUser($user);
        $this->assertInstanceOf(Token::class, $token);
        $this->assertEquals($user->id, $token->getClaim('uid'));
    }

    public function testParseTokenBadSign()
    {
        $user = new User();
        $user->id = 12;
        $token = AccessTokenHelper::createTokenForUser($user);
        $tokenAsString = (string)$token;

        $parsedToken = AccessTokenHelper::parseToken($tokenAsString, 'wrongSignKey');
        $this->assertNull($parsedToken);
    }

    public function testParseTokenExpired()
    {
        $user = new User();
        $user->id = 12;
        $token = AccessTokenHelper::createTokenForUser($user, time()-7200);
        $tokenAsString = (string)$token;

        $parsedToken = AccessTokenHelper::parseToken($tokenAsString);
        $this->assertNull($parsedToken);
    }

    public function testParseTokenInvalid()
    {
        $tokenAsString = 'qwe.asd';
        $parsedToken = AccessTokenHelper::parseToken($tokenAsString);
        $this->assertNull($parsedToken);
    }
}
