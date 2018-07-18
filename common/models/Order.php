<?php

namespace common\models;

use Yii;
use frontend\models\Menu;
use frontend\models\Restaurants;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property integer $foodId
 * @property integer $userId
 * @property integer $status
 * @property integer $restaurantId
 * @property float $price
 * @property float $pay_amount
 * @property string $data
 * @property \frontend\models\Restaurants $restaurants
 * @property \frontend\models\Menu $menu
 * @property \common\models\User $user
 * @property integer $realizedBy
 * @property \common\models\User $realizedByUser
 */
class Order extends \yii\db\ActiveRecord
{
    const STATUS_REALIZED = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['foodId', 'userId'], 'required'],
            [['foodId', 'userId','restaurantId', 'status'], 'integer'],
            [['data'], 'safe'],
            [['uwagi'],'string'],
            [['price', 'pay_amount'],'number', 'min' => 0.01, 'max' => 999.99],
            ['status', 'match', 'pattern' => '/[0-1]/'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'foodId' => 'Food ID',
            'userId' => 'User ID',
            'data' => 'Data',
            'uwagi'=> 'Uwagi',
            'status'=>'Status',
            'pay_amount'=>'Wpłata',
        ];
    }
    
    public function getUser()
    {
        return $this->hasOne(\common\models\User::className(),['id'=>'userId']);
    }

    public function getRealizedByUser()
    {
        return $this->hasOne(\common\models\User::className(),['id'=>'realizedBy']);
    }
    
    public function getMenu(){
        
        return $this->hasOne(Menu::className(),['id'=>'foodId']);
        
    }

    public function getRestaurantName()
    {
        if (null === $this->restaurants) {
            return '';
        }

        return $this->restaurants->restaurantName;
    }

    public function getFoodName()
    {
        if (null === $this->menu) {
            return '';
        }

        return $this->menu->foodName;
    }
    
     public function getRestaurants(){
    
        return $this->hasOne(Restaurants::className(),['id'=>'restaurantId']);
     }

    public function isCreatedByUser($userId = null)
    {
        if (null === $userId) {
            $userId = Yii::$app->user->identity->id;
        }
        return $this->userId == $userId;
    }

    public function cloneOrder($userId = null)
    {
        if (null === $userId) {
            $userId = Yii::$app->user->identity->id;
        }

        $order = clone $this;
        $order->isNewRecord = true;
        $order->id = null;
        $order->userId = $userId;
        return $order;
    }

    public function isRealized()
    {
        return $this->status == self::STATUS_REALIZED;
    }

    public function getPriceWithPack()
    {
        return 0.0 + $this->getPrice() + $this->restaurants->pack_price;
    }

    public function getPrice()
    {
        if ($this->status == self::STATUS_REALIZED) {
            return $this->price;
        }

        return $this->menu->foodPrice;
    }

    public function paymentChange($totalCost)
    {
        return $totalCost - $this->pay_amount;
    }
}
