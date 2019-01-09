<?php

namespace frontend\models;

use Yii;
use frontend\models\Restaurants;

/**
 * This is the model class for table "imagesmenu".
 *
 * @property integer $id
 * @property integer $restaurantId
 * @property string $imagesMenu_url
 */
class Imagesmenu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    
    public $imageFile;
    public static function tableName()
    {
        return 'imagesmenu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg',],
            [['restaurantId',], 'required'],
            [['restaurantId'], 'integer'],
            [['imagesMenu_url'], 'string', 'max' => 360],
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
            'imagesMenu_url' => 'Zdjęcie',
        ];
    }
    
    public function upload($restaurantId)
    {

            
        $this->imagesMenu_url = $this->imageFile->baseName . '.' . $this->imageFile->extension;
        $this->restaurantId = $restaurantId;
        
        if ($this->validate()) {
            $this->imageFile->saveAs('imagesMenu/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);

            return true;
        } else {
            return false;
        }
    }
    public function getRetaurants()
    {
        return $this->hasOne(Restaurants::className(), ['id'=>'restaurantId']);
    }
}
