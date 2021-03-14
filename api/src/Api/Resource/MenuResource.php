<?php

namespace App\Api\Resource;

use App\Api\Transformer\MenuTransformer;
use App\Restaurant\Entity\MenuPosition;
use League\Fractal\Resource\Collection;

class MenuResource
{
    /**
     * @param MenuPosition[] $restaurants
     *
     * @return Collection
     */
    public function factoryCollection(array $restaurants): Collection
    {
        return new Collection($restaurants, new MenuTransformer());
    }
}
