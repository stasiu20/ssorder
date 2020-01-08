<?php

namespace common\tests\unit\component;

use common\component\UserRestApiMediator;
use common\models\AccessToken;
use frontend\modules\apiV1\ApiV1Module;
use yii\redis\ActiveQuery;
use yii\redis\Connection;
use yii\web\Request;
use yii\web\User;

class UserRestApiMediatorTest extends \Codeception\Test\Unit
{
    public function testMediate(): void
    {
        $mediator = new UserRestApiMediator();

        $this->assertFalse(\Yii::$app->user->hasEventHandlers(User::EVENT_AFTER_LOGIN));
        $this->assertFalse(\Yii::$app->user->hasEventHandlers(User::EVENT_BEFORE_LOGOUT));
        $mediator->mediate();
        $this->assertTrue(\Yii::$app->user->hasEventHandlers(User::EVENT_AFTER_LOGIN));
        $this->assertTrue(\Yii::$app->user->hasEventHandlers(User::EVENT_BEFORE_LOGOUT));
    }

    public function testDeleteTokenBeforeLogout(): void
    {
        $userModelMock = $this->createMock(\common\models\User::class);
        $redisMock = $this->createMock(Connection::class);
        $tokenModelMock = $this->createMock(AccessToken::class);
        $tokenModelMock->expects(static::once())
            ->method('delete');

        $redisActiveQueryMock = $this->createMock(\yii\redis\ActiveQuery::class);
        $redisActiveQueryMock->expects(static::once())
            ->method('one')
            ->with()
            ->willReturn($tokenModelMock);
        $redisActiveQueryMock->expects(static::atLeastOnce())
            ->method('andWhere')
            ->willReturnSelf();

        $sessionMock = $this->createMock(\yii\web\Session::class);
        $sessionMock->expects(static::once())
            ->method('get')
            ->with($this->equalTo(UserRestApiMediator::JWT_SESSION_KEY))
            ->willReturn('foo');

        $moduleMock = $this->createMock(\yii\base\Module::class);
        $controllerMock = $this->createMock(\yii\web\Controller::class);
        $controllerMock->module = $moduleMock;

        \Yii::$container->set(
            ActiveQuery::class,
            function () use ($redisActiveQueryMock) {
                return $redisActiveQueryMock;
            }
        );
        \Yii::$app->set('redis', $redisMock);
        \Yii::$app->set('session', $sessionMock);
        \Yii::$app->set('request', new Request(['enableCsrfCookie' => false]));
        \Yii::$app->params = ['jwt_key' => 'foo'];
        \Yii::$app->controller = $controllerMock;

        $user = new User(['identityClass' => \common\models\User::class, 'enableSession' => false, 'enableAutoLogin' => false]);
        $user->setIdentity($userModelMock);
        $this->assertFalse($user->isGuest);

        $mediator = new UserRestApiMediator($user);
        $mediator->mediate();
        $user->logout();
    }

    public function testIgnoreDeleteTokenBeforeLogoutForApiModule(): void
    {
        $sessionMock = $this->createMock(\yii\web\Session::class);
        $sessionMock->expects(static::never())
            ->method('get');

        $userModelMock = $this->createMock(\common\models\User::class);
        $moduleMock = $this->createMock(ApiV1Module::class);
        $controllerMock = $this->createMock(\yii\web\Controller::class);
        $controllerMock->module = $moduleMock;
        \Yii::$app->controller = $controllerMock;
        \Yii::$app->set('session', $sessionMock);

        $user = new User(['identityClass' => \common\models\User::class, 'enableSession' => false, 'enableAutoLogin' => false]);
        $user->setIdentity($userModelMock);
        $this->assertFalse($user->isGuest);

        $mediator = new UserRestApiMediator($user);
        $mediator->mediate();
        $user->logout();
    }
}
