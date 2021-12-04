<?php

namespace frontend\modules\apiV1\models;

/**
 * @OA\Schema(
 *     title="Restaurant details",
 * )
 */
class RestaurantDetails
{
    /**
     * @var int
     *
     * @OA\Property(
     *     property="id",
     *     title="id",
     *     type="integer",
     *     format="int32",
     *     description="Restaurant id",
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
     *     description="Name of the restaurant",
     *     example="Pizza Pomidor",
     * )
     */
    public $name;

    /**
     * @var string
     *
     * @OA\Property(
     *     property="phone_number",
     *     title="phone_number",
     *     type="string",
     *     description="Restaurant's phone number",
     *     example="874585985",
     * )
     */
    public $phoneNumber;

    /**
     * @var Money
     *
     * @OA\Property(
     *     property="delivery_price",
     *     type="object",
     *     title="Delivery price",
     *     ref="#/components/schemas/Money",
     * )
     */
    public $deliveryPrice;

    /**
     * @var Money
     *
     * @OA\Property(
     *     property="pack_price",
     *     type="object",
     *     title="The cost of pack",
     *     ref="#/components/schemas/Money",
     * )
     */
    public $packPrice;

    /**
     * @var string
     *
     * @OA\Property(
     *     property="logo_url",
     *     title="logo_url",
     *     type="string",
     *     description="URL to restaurant logo",
     *     example="https://cdn.domain.com/foo.png",
     * )
     */
    public $logoUrl;

    /**
     * @var MenuItem[]
     *
     * @OA\Property(
     *     property="menu",
     *     title="Menu",
     *     type="array",
     *     description="Menu",
     *     @OA\Items(ref="#/components/schemas/MenuItem")
     * )
     */
    public $menu;

    /**
     * @var RestaurantPhoto[]
     *
     * @OA\Property(
     *     property="photos",
     *     title="Photos",
     *     type="array",
     *     description="Photos",
     *     @OA\Items(ref="#/components/schemas/RestaurantPhoto")
     * )
     */
    public $photos;
}
