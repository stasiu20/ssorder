<?php

namespace frontend\modules\apiV1\models\request;

use frontend\models\Menu;
use yii\base\Model;
use \OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="CreateOrderRequest",
 *     description="CreateOrderRequest model",
 *     @OA\Xml(
 *         name="CreateOrderRequest"
 *     )
 * )
 */
class CreateOrderRequest extends Model
{
    /**
     * @OA\Property(
     *     title="foodId",
     *     type="integer",
     *     description="Food id",
     *     example="48",
     * )
     * @var int|null
     */
    public $foodId;

    /**
     * @OA\Property(
     *     title="remarks",
     *     type="string",
     *     format="text",
     *     description="Remarks",
     *     example="Without sauce",
     * )
     * @var string|null
     */
    public $remarks;

    public function rules()
    {
        return [
            [['foodId', 'remarks'], 'required'],
            [['foodId'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::class, 'targetAttribute' => ['foodId' => 'id']],
        ];
    }

    public function addFoodError(string $message): void
    {
        $this->addError('foodId', \Yii::t('app', $message));
    }
}
