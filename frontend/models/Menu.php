<?php

namespace frontend\models;

use Yii;
use common\models\Order;
use yii\db\ActiveQuery;
use yii2tech\ar\softdelete\SoftDeleteBehavior;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property integer $restaurantId
 * @property string $foodName
 * @property string $foodInfo
 * @property double|string $foodPrice
 * @property-read string $deletedAt
 * @property Restaurants $restaurant
 * @property Restaurants[] $restaurants
 * @method softDelete
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['restaurantId', 'foodName', 'foodInfo', 'foodPrice'], 'required'],
            [['restaurantId'], 'integer'],
            [['foodInfo'], 'string'],
            [['foodPrice'], 'number', 'min' => 0.01, 'max' => 999.99],
            [['foodName'], 'string', 'max' => 200],
        ];
    }

    public function behaviors()
    {
        return [
            'softDeleteBehavior' => [
                'class' => SoftDeleteBehavior::class,
                'softDeleteAttributeValues' => [
                    'deletedAt' => function ($model) {
                        return date('Y-m-d');
                    }
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'restaurantId' => 'Restaurant ID',
            'foodName' => 'Nazwa Żarcia',
            'foodInfo' => 'Info o Żarciu',
            'foodPrice' => 'Cena Żarcia',
        ];
    }

    /**
     * @return ActiveQuery
     * @deprecated
     */
    public function getRestaurants(): ActiveQuery
    {
        Yii::warning(sprintf('Call deprecated method "%s". Backtrace: %s', __METHOD__, var_export(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS), true)));
        return $this->hasMany(Restaurants::className(), ['id' => 'restaurantId']);
    }

    public function getRestaurant(): ActiveQuery
    {
        return $this->hasOne(Restaurants::class, ['id' => 'restaurantId']);
    }

    public function getOrder(): ActiveQuery
    {
        return $this->hasMany(Order::className(), ['foodId'=>'id']);
    }
}
