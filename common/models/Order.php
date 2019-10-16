<?php

namespace common\models;

use Yii;
use frontend\models\Menu;
use frontend\models\Restaurants;
use yii\db\ActiveQuery;

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
 * @property float $total_price
 * @property string $data
 * @property string $uwagi
 * @property \frontend\models\Restaurants $restaurants
 * @property \frontend\models\Menu $menu
 * @property \common\models\User $user
 * @property integer $realizedBy
 * @property \common\models\User $realizedByUser
 */
class Order extends \yii\db\ActiveRecord
{
    const STATUS_REALIZED = 1;
    const STATUS_NOT_REALIZED = 0;
    const STATUS_CANCELED = 2;

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
            [['price', 'pay_amount', 'total_price'],'number', 'min' => 0.01, 'max' => 999.99],
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
            'foodId' => 'Żarcie',
            'userId' => 'Użytkownik',
            'data' => 'Data',
            'uwagi'=> 'Uwagi',
            'status'=>'Status',
            'pay_amount'=>'Wpłata',
            'total_price'=>'Do zapłaty',
            //todo mmo: move to search model
            'restaurantId' => 'Restauracja',
            'foodName' => 'Nazwa żarcia',
            'date' => 'Data zamówienia',
            'price' => 'Cena',
        ];
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(\common\models\User::className(), ['id'=>'userId']);
    }

    public function getRealizedByUser(): ActiveQuery
    {
        return $this->hasOne(\common\models\User::className(), ['id'=>'realizedBy']);
    }

    public function getMenu(): ActiveQuery
    {

        return $this->hasOne(Menu::className(), ['id'=>'foodId']);
    }

    public function getRestaurantName(): string
    {
        if (null === $this->restaurants) {
            return '';
        }

        return $this->restaurants->restaurantName;
    }

    public function getFoodName(): string
    {
        if (null === $this->menu) {
            return '';
        }

        return $this->menu->foodName;
    }

    public function getRestaurants(): ActiveQuery
    {

        return $this->hasOne(Restaurants::className(), ['id'=>'restaurantId']);
    }

    public function isCreatedByUser(int $userId = null): bool
    {
        if (null === $userId) {
            $userId = Yii::$app->user->identity->id;
        }
        return $this->userId == $userId;
    }

    public function cloneOrder(int $userId = null): Order
    {
        if (null === $userId) {
            $userId = Yii::$app->user->identity->id;
        }

        $order = clone $this;
        $order->isNewRecord = true;
        $order->id = null;
        $order->total_price = null;
        $order->pay_amount = null;
        $order->realizedBy = null;
        $order->status = self::STATUS_NOT_REALIZED;
        $order->userId = $userId;
        return $order;
    }

    public function isRealized(): bool
    {
        return $this->status == self::STATUS_REALIZED;
    }

    public function getPriceWithPack(): float
    {
        return 0.0 + $this->getPrice() + $this->restaurants->pack_price;
    }

    public function getPrice(): float
    {
        if ($this->status == self::STATUS_REALIZED) {
            return $this->price;
        }

        return $this->menu->foodPrice;
    }

    public function paymentChange(float $totalCost): float
    {
        return $totalCost - $this->pay_amount;
    }

    public function canBeRealized(\DateTimeInterface $compareToDate = null): bool
    {
        if (null === $compareToDate) {
            $compareToDate = (new \DateTimeImmutable('now'))->setTime(0, 0, 0);
        }
        // wiodace zero musi byc ustawione
        return $this->status === self::STATUS_NOT_REALIZED && (strpos($this->data, $compareToDate->format('Y-m-d')) === 0);
    }
}
