<?php

namespace App\phpstan;

use App\Restaurant\Entity\Category;
use App\Restaurant\Entity\MenuPosition;
use App\Restaurant\Entity\Restaurant;
use PHPStan\Reflection\PropertyReflection;
use PHPStan\Rules\Properties\ReadWritePropertiesExtension;

class OnlyReadProperties implements ReadWritePropertiesExtension
{
    public function isAlwaysRead(PropertyReflection $property, string $propertyName): bool
    {
        return false;
    }

    public function isAlwaysWritten(PropertyReflection $property, string $propertyName): bool
    {
        $declaringClass = $property->getDeclaringClass();
        $className = $declaringClass->getName();

        return ($propertyName === 'deletedAt' || $propertyName === 'deletedat')
            && in_array(
                $className,
                [Restaurant::class, Category::class, MenuPosition::class],
                true
            );
    }

    public function isInitialized(PropertyReflection $property, string $propertyName): bool
    {
        return false;
    }
}
