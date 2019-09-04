<?php

namespace frontend\models;

use Yii;
use frontend\models\Restaurants;
use yii\web\UploadedFile;

/**
 * This is the model class for table "imagesmenu".
 *
 * @property integer $id
 * @property integer $restaurantId
 * @property string $imagesMenu_url
 */
class Imagesmenu extends \yii\db\ActiveRecord
{
    /** @var UploadedFile|null */
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

    public function getTmpFileKey()
    {
        return $this->imageFile->baseName . mt_rand(1000, 9000) . '.' . $this->imageFile->extension;
    }

    public function getRetaurants()
    {
        return $this->hasOne(Restaurants::className(), ['id'=>'restaurantId']);
    }
}
