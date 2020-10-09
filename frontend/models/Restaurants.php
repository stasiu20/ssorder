<?php

namespace frontend\models;

use Yii;
use \yii\db\ActiveRecord;
use borales\extensions\phoneInput\PhoneInputValidator;
use borales\extensions\phoneInput\PhoneInputBehavior;
use common\models\Order;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii2tech\ar\softdelete\SoftDeleteBehavior;

/**
 * This is the model class for table "restaurants".
 *
 * @property integer $id
 * @property string $restaurantName
 * @property integer $tel_number
 * @property float|string $delivery_price
 * @property float|string $pack_price
 * @property string $img_url
 * @property int $categoryId
 * @property-read Category $category
 * @property-read Menu[] $menu
 * @property-read Imagesmenu[] $imagesmenu
 * @property-read string|null $deletedAt
 * @method softDelete
 */
class Restaurants extends ActiveRecord
{
    /** @var string */
    public $phone;

    /** @var UploadedFile|null */
    public $imageFile;

    const SCENARIO_UPDATE = 'update';
    const SCENARIO_UPLOAD = 'upload';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'restaurants';
    }

    public static function restaurantsAsArray(): array
    {
        $restaurants = self::find()->all();
        return ArrayHelper::map($restaurants, 'id', 'restaurantName');
    }

    public static function findActiveRestaurants(): \yii\db\ActiveQuery
    {
        $query = static::find();
        return $query->andWhere(['is', 'deletedAt', null]);
    }

    public function isActive(): bool
    {
        return null === $this->deletedAt;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'on'=>self::SCENARIO_UPDATE],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg',],
            [['restaurantName', 'tel_number', 'img_url', 'categoryId'], 'required',],
            //[['restaurantName', 'tel_number', 'delivery_price', 'pack_price', 'categoryId'], 'required', 'on'=>  self::SCENARIO_UPDATE],
            [['restaurantName', 'img_url','tel_number'], 'string'],
            [['delivery_price', 'pack_price'], 'default', 'value' => 0],
            [['delivery_price', 'pack_price'], 'number', 'min' => 0, 'max' => 999.99],
            [[ 'categoryId'], 'integer'],
            [['tel_number'],'string','max' => 12],
            [['tel_number'], PhoneInputValidator::class, 'default_region' => 'PL', 'region' => ['PL']],
        ];
    }


    public function scenarios()
    {

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
            'phoneInput' => PhoneInputBehavior::class,
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

    public function getTmpFileKey(): string
    {
        return $this->imageFile->baseName . mt_rand(1000, 9000) . '.' . $this->imageFile->extension;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
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

    public function getCategory(): \yii\db\ActiveQuery
    {
        return $this->hasOne(\frontend\models\Category::className(), ['id' => 'categoryId']);
    }

    public function getMenu(): \yii\db\ActiveQuery
    {
        return $this->hasMany(\frontend\models\Menu::className(), ['restaurantId' => 'id']);
    }

    public function getImagesmenu(): \yii\db\ActiveQuery
    {
        return $this->hasMany(Imagesmenu::className(), ['restaurantId' => 'id']);
    }


    public function getOrder(): \yii\db\ActiveQuery
    {
        return $this->hasMany(Order::className(), ['restaurantId' => 'id']);
    }
}
