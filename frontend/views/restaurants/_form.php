<?php

/* @var $this yii\web\View */

use frontend\assets\RestaurantAsset;
use frontend\models\Category;
use yii\helpers\ArrayHelper;

/* @var $model \frontend\models\Restaurants */
/* @var $form yii\bootstrap4\ActiveForm */

RestaurantAsset::register($this);
$this->registerJsVar('__APP_DATA__', [
    'restaurantData' => $model->getAttributes(['restaurantName', 'tel_number', 'delivery_price', 'pack_price', 'id', 'categoryId']),
    'categories' => ArrayHelper::map(Category::find()->all(), 'id', 'categoryName'),
])
?>

<div id="react-restaurant-form"></div>
