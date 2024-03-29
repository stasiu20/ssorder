<?php
/* @var $this yii\web\View */

use frontend\models\Category;
use yii\helpers\ArrayHelper;

$this->title = 'Order you posiłek';
$this->params['breadcrumbs'][] = $this->title;

/** @var $restaurants \frontend\models\Restaurants[] */
/** @var $restaurantFrontendData array */

\frontend\assets\RestaurantAsset::register($this);
$this->registerJsVar('__APP_DATA__', [
    'restaurants' => $restaurantFrontendData,
    'categories' => ArrayHelper::map(Category::find()->all(), 'id', 'categoryName'),
])
?>
<div class="site-index">
    <h2 class="text-center mb-4">To co dziś zamawiamy?!</h2>
    <div class="body-content">
        <div class="row"><div class="col-12"><div id="react-meilisearch"></div></div></div>
        <div class="row" id="react-restaurant-cards"></div>
    </div>
</div>
