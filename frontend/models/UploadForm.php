<?php

namespace frontend\models;

use yii\base\Model;
use yii\web\UploadedFile;
use yii\web\Restaurants;
use frontend\models\Restaurants;

class UploadForm extends Model {

    /**
     * @var UploadedFile
     */
    public $imageFile;
    public $restaurantName;
    public $tel_number;
    public $delivery_price;
    public $pack_price;

    public function rules() {
        return [
            [['restaurantName', 'imageFile', 'tel_number', 'delivery_price', 'pack_price'], 'required'],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
            [['restaurantName',], 'string'],
            [['tel_number', 'delivery_price', 'pack_price'], 'integer'],
        ];
    }

    public function upload() {
        if ($this->validate()) {

            $this->imageFile->saveAs('image/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);

            return true;
        } else {
            return false;
        }
    }

}
