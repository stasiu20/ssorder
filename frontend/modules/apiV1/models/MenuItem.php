<?php

namespace frontend\modules\apiV1\models;

use yii\base\Model;

/**
 * @OA\Schema(
 *     title="Restaurant menu item",
 * )
 */
class MenuItem extends Model
{
    /**
     * @var int
     *
     * @OA\Property(
     *     property="id",
     *     title="id",
     *     type="integer",
     *     format="int32",
     *     description="Menu item id",
     *     example="1",
     * )
     */
    public $id;

    /**
     * @var string
     *
     * @OA\Property(
     *     property="name",
     *     title="name",
     *     type="string",
     *     description="Menu item name",
     *     example="Burger duży",
     * )
     */
    public $name;

    /**
     * @var string
     *
     * @OA\Property(
     *     property="description",
     *     title="Description",
     *     type="string",
     *     description="Desscription",
     *     example="Papryczna chili, gotowana cebulka, roszponka, ser, salami",
     * )
     */
    public $description;

    /**
     * @var Money
     *
     * @OA\Property(
     *     title="price",
     *     type="object",
     *     description="Price",
     *     ref="#/components/schemas/Money",
     * )
     */
    public $price;
}
