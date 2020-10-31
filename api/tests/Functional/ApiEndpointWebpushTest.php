<?php

namespace App\Tests\Functional;

use App\Entity\User;
use App\Tests\Factory\UserFactory;
use App\Tests\Factory\UserSubscriptionFactory;
use App\Tests\Story\UserWithWebPushSubscriptionStory;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTManager;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\Test\Factories;

class ApiEndpointWebpushTest extends WebTestCase
{
    use Factories;

    /**
     * @group database
     */
    public function testCreateWebpush(): void
    {
        self::bootKernel();
        /** @var JWTManager $jwtManager */
        $jwtManager = self::$container->get('lexik_jwt_authentication.jwt_manager');

        /** @var User|Proxy $user */
        $user = UserFactory::repository()->findOneBy(['username' => 'sonia.baran']);

        UserSubscriptionFactory::repository()->assertEmpty();
        self::assertNotNull($user);

        self::ensureKernelShutdown();
        $token = $jwtManager->create($user->object());
        $client = $this->getHTTPClient($token);
        $body = [
            'subscription' => ['endpoint' => 'foo'],
            'options' => [],
        ];
        $client->request('POST', '/api/webpush', [], [], [], json_encode($body));

        self::assertResponseIsSuccessful();
        UserSubscriptionFactory::repository()->assertCount(1);
    }

    /**
     * @group database
     */
    public function testDeleteWebpush(): void
    {
        $story = UserWithWebPushSubscriptionStory::load();

        self::bootKernel();
        /** @var JWTManager $jwtManager */
        $jwtManager = self::$container->get('lexik_jwt_authentication.jwt_manager');

        /** @var User|Proxy $user */
        $user = $story->get('user');

        UserSubscriptionFactory::repository()->assertCount(1);
        self::assertNotNull($user);

        self::ensureKernelShutdown();
        $token = $jwtManager->create($user->object());
        $client = $this->getHTTPClient($token);
        $body = [
            'subscription' => ['endpoint' => 'foo'],
            'options' => [],
        ];
        $client->request('DELETE', '/api/webpush', [], [], [], json_encode($body));

        self::assertResponseIsSuccessful();
        UserSubscriptionFactory::repository()->assertCount(0);
    }

    /**
     * @param string $jwtToken
     * @return KernelBrowser
     */
    private function getHTTPClient(string $jwtToken): KernelBrowser
    {
        $client = self::createClient();
        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $jwtToken));

        return $client;
    }
}
