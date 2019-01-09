<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RestaurantsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Restaurants';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="restaurants-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Restaurants', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'restaurantName:ntext',
            'tel_number',
            'delivery_price',
             'pack_price',
             'img_url:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
