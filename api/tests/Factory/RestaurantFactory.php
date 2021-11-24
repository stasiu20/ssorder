<?php

namespace App\Tests\Factory;

use App\Restaurant\Entity\Restaurant;
use App\Restaurant\Repository\RestaurantRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Restaurant>
 *
 * @method static Restaurant|Proxy createOne(array $attributes = [])
 * @method static Restaurant[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Restaurant|Proxy find(object|array|mixed $criteria)
 * @method static Restaurant|Proxy findOrCreate(array $attributes)
 * @method static Restaurant|Proxy first(string $sortedField = 'id')
 * @method static Restaurant|Proxy last(string $sortedField = 'id')
 * @method static Restaurant|Proxy random(array $attributes = [])
 * @method static Restaurant|Proxy randomOrCreate(array $attributes = [])
 * @method static Restaurant[]|Proxy[] all()
 * @method static Restaurant[]|Proxy[] findBy(array $attributes)
 * @method static Restaurant[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Restaurant[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static RestaurantRepository|RepositoryProxy repository()
 * @method Restaurant|Proxy create(array|callable $attributes = [])
 */
final class RestaurantFactory extends ModelFactory
{
    protected function getDefaults(): array
    {
        return [
            'name' => self::faker()->text(50),
            'phoneNumber' => self::faker()->e164PhoneNumber(),
            'imgUrl' => self::faker()->url(),
            'categoryId' => self::faker()->randomNumber(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Restaurant $restaurant) {})
        ;
    }

    protected static function getClass(): string
    {
        return Restaurant::class;
    }
}
