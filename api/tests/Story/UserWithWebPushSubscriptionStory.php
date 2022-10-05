<?php

namespace App\Tests\Story;

use App\Service\UserSubscriptionManager;
use App\Tests\Factory\UserFactory;
use App\Tests\Factory\UserSubscriptionFactory;
use Zenstruck\Foundry\Story;

final class UserWithWebPushSubscriptionStory extends Story
{
    /**
     * @var UserSubscriptionManager
     */
    private $subscriptionManager;

    public function __construct(UserSubscriptionManager $subscriptionManager)
    {
        $this->subscriptionManager = $subscriptionManager;
    }

    public function build(): void
    {
        $endpoint = 'foo';

        $user = UserFactory::repository()->findOneBy(['username' => 'sonia.baran']);
        $subscription = UserSubscriptionFactory::new([
            'user' => $user,
            'subscriptionHash' => $this->subscriptionManager->hash($endpoint, $user->object()),
            'subscription' => ['endpoint' => $endpoint]
        ])->create();

        $this->addState('user', $user);
        $this->addState('subscription', $subscription);
    }
}
