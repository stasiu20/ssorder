<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $categoryName
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
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['categoryName'], 'required'],
            [['categoryName'], 'string', 'max' => 200],
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
