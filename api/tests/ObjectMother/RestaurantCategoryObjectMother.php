<?php

namespace App\Tests\ObjectMother;

use App\Restaurant\Entity\Category;
use ReflectionClass;
use Symfony\Component\PropertyAccess\PropertyAccess;

class RestaurantCategoryObjectMother
{
    public static function create(array $attributes): Category
    {
        $accessor = PropertyAccess::createPropertyAccessor();
        $category = new Category();
        self::set($category, $attributes['id'] ?? null, 'id');
        unset($attributes['id']);

        foreach ($attributes as $attribute => $value) {
            $accessor->setValue($category, $attribute, $value);
        }

        return $category;
    }

    private static function set($entity, $value, $propertyName = 'id'): void
    {
        $class = new ReflectionClass($entity);
        $property = $class->getProperty($propertyName);
        $property->setAccessible(true);

        $property->setValue($entity, $value);
    }
}
