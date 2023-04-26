<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\UserSubscription;
use App\Webpush\Exception\UnexpectedTypeException;
use BenTools\WebPushBundle\Model\Subscription\UserSubscriptionInterface;
use BenTools\WebPushBundle\Model\Subscription\UserSubscriptionManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

class UserSubscriptionManager implements UserSubscriptionManagerInterface
{
    /**
     * @var ManagerRegistry
     */
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @inheritDoc
     * @phpstan-ignore-next-line
     */
    public function factory(
        UserInterface $user,
        string $subscriptionHash,
        array $subscription,
        array $options = []
    ): UserSubscriptionInterface {
        if (!$user instanceof User) {
            throw new UnexpectedTypeException($user, User::class);
        }

        // $options is an arbitrary array that can be provided through the front-end code.
        // You can use it to store meta-data about the subscription: the user agent, the referring domain, ...
        return new UserSubscription($user, $subscriptionHash, $subscription);
    }

    /**
     * @inheritDoc
     */
    public function hash(string $endpoint, UserInterface $user): string
    {
        return md5($endpoint); // Encode it as you like
    }

    /**
     * @inheritDoc
     */
    public function getUserSubscription(UserInterface $user, string $subscriptionHash): ?UserSubscriptionInterface
    {
        /** @var UserSubscriptionInterface|null $obj */
        $obj = $this->doctrine->getManager()->getRepository(UserSubscription::class)->findOneBy([
            'user' => $user,
            'subscriptionHash' => $subscriptionHash,
        ]);

        return $obj;
    }

    /**
     * @inheritDoc
     */
    public function findByUser(UserInterface $user): iterable
    {
        return $this->doctrine->getManager()->getRepository(UserSubscription::class)->findBy([
            'user' => $user,
        ]);
    }

    /**
     * @inheritDoc
     * @phpstan-ignore-next-line
     */
    public function findByHash(string $subscriptionHash): iterable
    {
        return $this->doctrine->getManager()->getRepository(UserSubscription::class)->findBy([
            'subscriptionHash' => $subscriptionHash,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function save(UserSubscriptionInterface $userSubscription): void
    {
        $this->doctrine->getManager()->persist($userSubscription);
        $this->doctrine->getManager()->flush();
    }

    /**
     * @inheritDoc
     */
    public function delete(UserSubscriptionInterface $userSubscription): void
    {
        $this->doctrine->getManager()->remove($userSubscription);
        $this->doctrine->getManager()->flush();
    }
}
