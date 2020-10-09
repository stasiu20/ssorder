<?php

namespace common\transformers;

use common\models\Order;
use League\Fractal\TransformerAbstract;
use \OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Order",
 *     description="Order model",
 *     schema="Order",
 *     @OA\Xml(
 *         name="Order"
 *     )
 * )
 *
 * @OA\Property(
 *     property="id",
 *     title="id",
 *     type="integer",
 *     format="int32",
 *     description="Order id",
 *     example="1",
 * )
 * @OA\Property(
 *     property="foodId",
 *     title="foodId",
 *     type="integer",
 *     description="Food Id",
 *     example="1",
 * )
 * @OA\Property(
 *     property="restaurant",
 *     title="Restaurant",
 *     type="integer",
 *     description="Restaurant to which orderis assigned",
 *     example="1",
 * )
 */
class OrderTransformer extends TransformerAbstract
{
    /**
     * @param Order $data
     * @return array
     */
    public function transform(Order $data): array
    {
        return [
            'id' => $data->id,
            'foodId' => (int)$data->foodId,
            'restaurantId' => (int)$data->restaurantId,
        ];
    }
}
