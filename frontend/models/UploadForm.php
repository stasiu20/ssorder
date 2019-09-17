<?php

namespace frontend\models;

use yii\base\Model;
use yii\web\UploadedFile;

/**
* @SuppressWarnings(PHPMD.CamelCasePropertyName)
*/
class UploadForm extends Model
{

    /**
     * @var UploadedFile
     */
    public $imageFile;

    /** @var string */
    public $restaurantName;

    /** @var string */
    public $tel_number;

    /** @var string|float */
    public $delivery_price;

    /** @var string|float */
    public $pack_price;

    public function rules()
    {
        return [
            [['restaurantName', 'imageFile', 'tel_number', 'delivery_price', 'pack_price'], 'required'],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
            [['restaurantName',], 'string'],
            [['tel_number', 'delivery_price', 'pack_price'], 'integer'],
        ];
    }

    /**
     * @deprecated
     * @return bool
     */
    public function upload(): bool
    {
        if ($this->validate()) {
            $this->imageFile->saveAs('image/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        }
        return false;
    }
}
