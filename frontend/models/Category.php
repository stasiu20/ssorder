<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveQuery;
use yii2tech\ar\softdelete\SoftDeleteBehavior;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $categoryName
 * @method softDelete
 */
class Category extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @return ActiveQuery
     */
    public static function findActive()
    {
        $query = self::find();
        return $query->andWhere(['is', 'deletedAt', null]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['categoryName'], 'required'],
            [['categoryName'], 'string', 'max' => 200],
        ];
    }

    public function behaviors()
    {
        return [
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

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'categoryName' => 'Category Name',
        ];
    }

    public function getRestaurants(): ActiveQuery
    {
        return $this->hasMany(\frontend\models\Restaurants::className(), ['categoryId' => 'id']);
    }
}
