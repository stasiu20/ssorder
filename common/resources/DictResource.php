<?php

namespace common\resources;

use common\transformers\DictCategoryTransformer;
use frontend\models\Category;
use League\Fractal\Resource\Collection;

class DictResource
{
    /**
     * @param Category[] $categories
     * @return Collection
     */
    public static function factoryRestaurantCategoryCollection(array $categories): Collection
    {
        return new Collection($categories, new DictCategoryTransformer());
    }
}
