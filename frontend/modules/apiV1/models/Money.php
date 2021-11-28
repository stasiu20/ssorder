<?php

namespace frontend\modules\apiV1\models;

/**
 * @OA\Schema(
 *     title="Money",
 * )
 */
class Money
{
    /**
     * @var string
     *
     * @OA\Property (
     *     property="amount",
     *     type="string",
     *     description="Ammount in cents",
     *     example="500"
     * ),
     */
    public $amount;

    /**
     * @var string
     *
     * @OA\Property (
     *     property="currency",
     *     type="string",
     *     description="Currency",
     *     example="PLN"
     * )
     */
    public $currency;
}
