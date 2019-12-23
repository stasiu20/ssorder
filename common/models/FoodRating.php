<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "food_rating".
 *
 * @property int $id
 * @property int $order_id
 * @property int $user_id
 * @property int $rating
 * @property string $date
 * @property string $review
 *
 * @property Order $order
 * @property User $user
 */
class FoodRating extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'food_rating';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'user_id', 'rating'], 'required'],
            [['order_id', 'user_id'], 'integer'],
            [['rating'], 'integer', 'min' => 1, 'max' => 5],
            [['date'], 'date', 'format' => 'php:Y-m-d H:i:s'],
            [['review'], 'string', 'max' => 1000],
            [['order_id'], 'unique', 'skipOnError' => true],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::class, 'targetAttribute' => ['order_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'order_id' => Yii::t('app', 'Order ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'rating' => Yii::t('app', 'Rating'),
            'date' => Yii::t('app', 'Date'),
            'review' => Yii::t('app', 'Review'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::class, ['id' => 'order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
