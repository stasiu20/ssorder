<?php

namespace frontend\modules\apiV1\models;

use frontend\models\Menu;
use \OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Food",
 *     description="Food model",
 *     @OA\Xml(
 *         name="Food"
 *     )
 * )
 */
class Food extends Menu
{
    /**
     * @OA\Property(
     *     property="id",
     *     title="id",
     *     type="integer",
     *     format="int32",
     *     description="Food id",
     *     example="1",
     * )
     * @OA\Property(
     *     property="restaurantId",
     *     title="restaurantId",
     *     type="integer",
     *     format="int32",
     *     description="Restaurant id",
     *     example="2",
     * )
     * @OA\Property(
     *     property="foodName",
     *     title="foodName",
     *     type="string",
     *     description="Name of the food",
     *     example="Pizza 43cm",
     * )
     * @OA\Property(
     *     property="foodInfo",
     *     title="foodInfo",
     *     type="string",
     *     description="Additional information",
     *     example="sałata, pomidor, ogórek kiszony, czerwona cebula, bekon, sos",
     * )
     * @OA\Property(
     *     property="foodPrice",
     *     title="foodPrice",
     *     type="number",
     *     description="Price",
     *     example="19.99",
     * )
     */
    public function fields(): array
    {
        return [
            'id',
            'restaurantId',
            'foodName',
            'foodInfo',
            'foodPrice' => function (Food $model) {
                return (float)$model->foodPrice;
            },
        ];
    }
}
