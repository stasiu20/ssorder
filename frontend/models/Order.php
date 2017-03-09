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
 * @property string $data
 */
class Order extends \yii\db\ActiveRecord
{
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
}
