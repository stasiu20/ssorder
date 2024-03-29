<?php

namespace App\Api\Transformer;

use App\Restaurant\Entity\Category;
use League\Fractal\TransformerAbstract;

class RestaurantCategoryTransformer extends TransformerAbstract
{
    /**
     * @param Category $data
     *
     * @return array{id: int, name: string}
     */
    public function transform(Category $data): array
    {
        return [
            'id' => $data->getId(),
            'name' => $data->getName(),
        ];
    }
}
