<?php

namespace common\tests\unit\resources;

use Codeception\Test\Unit;
use common\resources\RestaurantResource;
use frontend\modules\apiV1\models\Restaurant;
use League\Fractal\Resource\Collection;

class RestaurantResourceTest extends Unit
{
    /**
     * @dataProvider collectionProvider
     */
    public function testFactoryCollection(array $restaurants): void
    {
        $resource = RestaurantResource::factoryCollection($restaurants);
        $this->assertInstanceOf(Collection::class, $resource);
        $this->assertCount(count($restaurants), $resource->getData());
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
