<?php

namespace App\Tests\Factory;

use App\Entity\User;
use App\Repository\UserRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static User|Proxy findOrCreate(array $attributes)
 * @method static User|Proxy random()
 * @method static User[]|Proxy[] randomSet(int $number)
 * @method static User[]|Proxy[] randomRange(int $min, int $max)
 * @method static UserRepository|RepositoryProxy repository()
 * @method User|Proxy create($attributes = [])
 * @method User[]|Proxy[] createMany(int $number, $attributes = [])
 */
final class UserFactory extends ModelFactory
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
            // ->afterInstantiate(function(User $user) {})
        ;
    }

    protected static function getClass(): string
    {
        return User::class;
    }
}
