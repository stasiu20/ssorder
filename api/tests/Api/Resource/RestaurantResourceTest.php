<?php

namespace App\Tests\Api\Resource;

use App\Restaurant\Entity\Restaurant;
use App\Tests\ObjectMother\RestaurantResourceObjectMother;
use League\Fractal\Resource\Collection;
use PHPUnit\Framework\TestCase;

class RestaurantResourceTest extends TestCase
{
    /**
     * @dataProvider collectionProvider
     */
    public function testFactoryCollection(array $restaurants): void
    {
        $resource = RestaurantResourceObjectMother::create();
        $collection = $resource->factoryCollection($restaurants);

        $this->assertInstanceOf(Collection::class, $collection);
        $this->assertCount(count($restaurants), $collection->getData());
    }

    public function collectionProvider(): array
    {
        $restaurant1 = new Restaurant();
        $restaurant2 = new Restaurant();

        return [
            [[]],
            [[$restaurant1, $restaurant2]],
        ];
    }
}
