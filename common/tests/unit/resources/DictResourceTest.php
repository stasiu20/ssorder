<?php

namespace common\tests\unit\resources;

use Codeception\Test\Unit;
use common\models\Order;
use common\resources\DictResource;
use common\resources\OrderResource;
use frontend\models\Category;
use frontend\modules\apiV1\models\Restaurant;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

class DictResourceTest extends Unit
{
    /**
     * @dataProvider collectionDicCategoryProvider
     * @param Category[] $categories
     */
    public function factoryRestaurantCategoryCollection(array $categories): void
    {
        $resource = DictResource::factoryRestaurantCategoryCollection($categories);

        $this->assertInstanceOf(Collection::class, $resource);
        $this->assertCount(count($categories), $resource->getData());
    }

    public function collectionDicCategoryProvider(): array
    {
        $category1 = new Category();
        $category2 = new Category();

        return [
            [[]],
            [[$category1, $category2]],
        ];
    }
}
