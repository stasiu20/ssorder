<?php

namespace App\Tests\ObjectMother;

use App\Restaurant\Entity\Restaurant;
use ReflectionClass;
use Symfony\Component\PropertyAccess\PropertyAccess;

class RestaurantObjectMother
{
    public static function create(array $attributes): Restaurant
    {
        $accessor = PropertyAccess::createPropertyAccessor();
        $restaurant = new Restaurant();
        self::set($restaurant, $attributes['id'] ?? null, 'id');
        unset($attributes['id']);

        foreach ($attributes as $attribute => $value) {
            $accessor->setValue($restaurant, $attribute, $value);
        }

        return $restaurant;
    }

    private static function set($entity, $value, $propertyName = 'id'): void
    {
        $class = new ReflectionClass($entity);
        $property = $class->getProperty($propertyName);
        $property->setAccessible(true);

        $property->setValue($entity, $value);
    }
}
