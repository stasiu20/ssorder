<?php

namespace frontend\modules\apiV1\models;

use frontend\models\Restaurants;
use \OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Restaurant",
 *     description="Restaurant model",
 *     @OA\Xml(
 *         name="Restaurant"
 *     )
 * )
 */
class Restaurant extends Restaurants
{
    /**
     * @OA\Property(
     *     property="id",
     *     title="id",
     *     type="integer",
     *     format="int32",
     *     description="Restaurant id",
     *     example="1",
     * )
     * @OA\Property(
     *     property="name",
     *     title="name",
     *     type="string",
     *     description="Name of the restaurant",
     *     example="Pizza Pomidor",
     * )
     * @OA\Property(
     *     property="telNumber",
     *     title="telNumber",
     *     type="string",
     *     description="Restaurant's phone number",
     *     example="874585985",
     * )
     * @OA\Property(
     *     property="deliveryPrice",
     *     title="deliveryPrice",
     *     type="number",
     *     description="Delivery price",
     *     example="5.50",
     * )
     * @OA\Property(
     *     property="packPrice",
     *     title="packPrice",
     *     type="number",
     *     description="The cost of pack",
     *     example="0.5",
     * )
     * @OA\Property(
     *     property="imageUrl",
     *     title="imageUrl",
     *     type="string",
     *     description="URL to restaurant image",
     *     example="/foo.png",
     * )
     * @OA\Property(
     *     property="category",
     *     title="categoryId",
     *     type="integer",
     *     description="Category to which restaurant is assigned",
     *     example="1",
     * )
     */
    public function fields(): array
    {
        return [
            'id',
            'restaurantName',
            'phoneNumber' => 'tel_number',
            'deliveryPrice' => function (Restaurant $model) {
                return (float)$model->delivery_price;
            },
            'packPrice' => function (Restaurant $model) {
                return (float)$model->pack_price;
            },
            'imgUrl' => 'img_url',
            'categoryId',
        ];
    }
}
