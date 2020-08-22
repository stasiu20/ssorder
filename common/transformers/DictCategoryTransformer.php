<?php

namespace common\transformers;

use frontend\models\Category;
use League\Fractal\TransformerAbstract;

/**
 * @OA\Schema(
 *     title="Restaurant category",
 *     description="Restaurant category model",
 *     schema="RestaurantCategory",
 *     @OA\Xml(
 *         name="RestaurantCategory"
 *     )
 * )
 *
 * @OA\Property(
 *     property="id",
 *     title="id",
 *     type="integer",
 *     format="int32",
 *     description="Category id",
 *     example="1",
 * )
 * @OA\Property(
 *     property="name",
 *     title="name",
 *     type="string",
 *     description="Name of the category",
 *     example="Kebab",
 * )
 */
class DictCategoryTransformer extends TransformerAbstract
{
    /**
     * @param Category $data
     * @return array
     */
    public function transform(Category $data): array
    {
        return [
            'id' => $data->id,
            'name' => $data->categoryName,
        ];
    }
}
