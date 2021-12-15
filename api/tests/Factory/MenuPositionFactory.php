<?php

namespace App\Tests\Factory;

use App\Restaurant\Entity\MenuPosition;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<MenuPosition>
 *
 * @method static MenuPosition|Proxy createOne(array $attributes = [])
 * @method static MenuPosition[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static MenuPosition|Proxy find(object|array|mixed $criteria)
 * @method static MenuPosition|Proxy findOrCreate(array $attributes)
 * @method static MenuPosition|Proxy first(string $sortedField = 'id')
 * @method static MenuPosition|Proxy last(string $sortedField = 'id')
 * @method static MenuPosition|Proxy random(array $attributes = [])
 * @method static MenuPosition|Proxy randomOrCreate(array $attributes = [])
 * @method static MenuPosition[]|Proxy[] all()
 * @method static MenuPosition[]|Proxy[] findBy(array $attributes)
 * @method static MenuPosition[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static MenuPosition[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method MenuPosition|Proxy create(array|callable $attributes = [])
 */
final class MenuPositionFactory extends ModelFactory
{
    protected function getDefaults(): array
    {
        return [
            'foodname' => self::faker()->text(50),
            'foodinfo' => self::faker()->text(100),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(MenuPosition $menuPosition) {})
        ;
    }

    protected static function getClass(): string
    {
        return MenuPosition::class;
    }
}
