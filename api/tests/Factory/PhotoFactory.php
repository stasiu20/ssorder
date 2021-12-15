<?php

namespace App\Tests\Factory;

use App\Restaurant\Entity\Photo;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Photo>
 *
 * @method static Photo|Proxy createOne(array $attributes = [])
 * @method static Photo[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Photo|Proxy find(object|array|mixed $criteria)
 * @method static Photo|Proxy findOrCreate(array $attributes)
 * @method static Photo|Proxy first(string $sortedField = 'id')
 * @method static Photo|Proxy last(string $sortedField = 'id')
 * @method static Photo|Proxy random(array $attributes = [])
 * @method static Photo|Proxy randomOrCreate(array $attributes = [])
 * @method static Photo[]|Proxy[] all()
 * @method static Photo[]|Proxy[] findBy(array $attributes)
 * @method static Photo[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Photo[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method Photo|Proxy create(array|callable $attributes = [])
 */
final class PhotoFactory extends ModelFactory
{
    protected function getDefaults(): array
    {
        return [];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Photo $photo) {})
        ;
    }

    protected static function getClass(): string
    {
        return Photo::class;
    }

    public function markAsDeleted(): self
    {
        return $this->afterInstantiate(function (Photo $photo) {
            $photo->markAsDeleted();
        });
    }
}
