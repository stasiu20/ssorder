<?php

namespace App\Tests\Factory;

use App\Entity\UserSubscription;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static UserSubscription|Proxy findOrCreate(array $attributes)
 * @method static UserSubscription|Proxy random()
 * @method static UserSubscription[]|Proxy[] randomSet(int $number)
 * @method static UserSubscription[]|Proxy[] randomRange(int $min, int $max)
 * @method UserSubscription|Proxy create($attributes = [])
 * @method UserSubscription[]|Proxy[] createMany(int $number, $attributes = [])
 */
final class UserSubscriptionFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function getDefaults(): array
    {
        return [
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this
            // ->afterInstantiate(function(UserSubscription $userSubscription) {})
        ;
    }

    protected static function getClass(): string
    {
        return UserSubscription::class;
    }
}
