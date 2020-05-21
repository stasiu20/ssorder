<?php

use frontend\models\Category;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use frontend\models\Restaurants;

/* @var $this yii\web\View */
/* @var $model Restaurants */

$this->title = 'Create Restaurants';
$this->params['breadcrumbs'][] = ['label' => 'Restaurants', 'url' => ['/restaurants']];
$this->params['breadcrumbs'][] = $this->title;

\frontend\assets\RestaurantAsset::register($this);
$this->registerJsVar('__APP_DATA__', [
    'restaurantData' => $model->getAttributes(['restaurantName', 'tel_number', 'delivery_price', 'pack_price']),
    'categories' => ArrayHelper::map(Category::find()->all(), 'id', 'categoryName'),
])
?>
<div class="restaurants-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <div id="react-restaurant-form"></div>
</div>
