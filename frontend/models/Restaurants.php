<?php

namespace frontend\models;

use Yii;
use \yii\db\ActiveRecord;
use borales\extensions\phoneInput\PhoneInputValidator;
use borales\extensions\phoneInput\PhoneInputBehavior;
use common\models\Order;

/**
 * This is the model class for table "restaurants".
 *
 * @property integer $id
 * @property string $restaurantName
 * @property integer $tel_number
 * @property float $delivery_price
 * @property float $pack_price
 * @property string $img_url
 */
class Restaurants extends ActiveRecord {
    public $phone;
   
    public $imageFile;
    
    const SCENARIO_UPDATE = 'update';
    const SCENARIO_UPLOAD = 'upload';

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'restaurants';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            //[['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'on'=>self::SCENARIO_UPDATE],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg',],
            [['restaurantName', 'tel_number', 'img_url', 'categoryId'], 'required',],
            //[['restaurantName', 'tel_number', 'delivery_price', 'pack_price', 'categoryId'], 'required', 'on'=>  self::SCENARIO_UPDATE],
            [['restaurantName', 'img_url','tel_number'], 'string'],
            [['delivery_price', 'pack_price'], 'default', 'value' => 0],
            [['delivery_price', 'pack_price'], 'number', 'min' => 0, 'max' => 999.99],
            [[ 'categoryId'], 'integer'],
            [['tel_number'],'string','length'=>[11, 12]],
            ['tel_number', 'match', 'pattern' => '/([0-9]{3}-[0-9]{3}-[0-9]{3})|([0-9]{4}-[0-9]{2}-[0-9]{2})/']
            //[['tel_number'], PhoneInputValidator::className(), 'region' => ['PL']],
        ];
    }
   

    public function scenarios() {

        return[
            self::SCENARIO_UPDATE => ['restaurantName', 'tel_number', 'delivery_price', 'pack_price', 'categoryId',],
                                 [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg',],
                                 [['tel_number'], PhoneInputValidator::className(),'region' => ['PL']],
            self::SCENARIO_UPLOAD => ['restaurantName', 'tel_number', 'delivery_price', 'pack_price', 'categoryId', 'img_url', 'imageFile',],
                                 [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg',],
                                 [['tel_number'], PhoneInputValidator::className(),'region' => ['PL']],
                ];
    }
    
    public function behaviors()
    {

      
        return [
            'phoneInput' => PhoneInputBehavior::className(),
        ];
    }

    public function upload() {
        
        $this->img_url = $this->imageFile->baseName . '.' . $this->imageFile->extension;
        if ($this->validate()) {
            $this->imageFile->saveAs('image/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'restaurantName' => 'Nazwa Restauracji',
            'tel_number' => 'Numer telefonu',
            'delivery_price' => 'Cena dostawy',
            'pack_price' => 'Cena opakowania',
            'img_url' => 'Img Url',
            'categoryId' => 'Wybierz Kategorię',
            'imageFile' => 'Zdjęcie'
        ];
    }

    public function getCategory() {
        return $this->hasOne(\frontend\models\Category::className(), ['id' => 'categoryId']);
    }

    public function getMenu() {
        return $this->hasMany(\frontend\models\Menu::className(), ['restaurantId' => 'id']);
    }

    public function getImagesmenu() {
        return $this->hasMany(Imagesmenu::className(), ['restaurantId' => 'id']);
    }
    
    
     public function getOrder() {
        return $this->hasMany(Order::className(), ['restaurantId' => 'id']);
    }

}

