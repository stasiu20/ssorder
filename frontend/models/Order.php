<?php

namespace frontend\models;

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
 * @property string $data
 * @property \frontend\models\Restaurants $restaurants
 * @property \frontend\models\Menu $menu
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
            'status'=>'Status'
        ];
    }
    
    public function getUser(){
        
        return $this->hasOne(\common\models\User::className(),['id'=>'userId']);
        
        
    }
    
    public function getMenu(){
        
        return $this->hasOne(Menu::className(),['id'=>'foodId']);
        
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

    public function cloneOrder()
    {
        $order = clone $this;
        $order->isNewRecord = true;
        $order->id = null;
        return $order;
    }

    public function isRealized()
    {
        return $this->status == self::STATUS_REALIZED;
    }
}
