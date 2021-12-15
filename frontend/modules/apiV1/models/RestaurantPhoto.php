<?php

namespace frontend\modules\apiV1\models;

/**
 * @OA\Schema(
 *     title="Restaurant menu item",
 * )
 */
class RestaurantPhoto
{
    /**
     * @var int
     *
     * @OA\Property(
     *     property="id",
     *     title="id",
     *     type="integer",
     *     format="int32",
     *     description="Photo id",
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
     *     description="URL to photo",
     *     example="https://cdn.domain.com/foo.png",
     * )
     */
    public $url;
}
