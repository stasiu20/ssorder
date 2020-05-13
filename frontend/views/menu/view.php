<?php

use yii\grid\ActionColumn;
use yii\grid\SerialColumn;
use yii\data\DataProviderInterface;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Menu */
/* @var $restaurant frontend\models\Restaurants */
/* @var $lastOrdersProvider DataProviderInterface */

$request = Yii::$app->request;
$order = $request->get('order');

$restaurantName = $restaurant->restaurantName;
$this->title = $model->foodName;
if ($order) {
    $this->params['breadcrumbs'][] = ['label' => 'Zamówienia', 'url' => Url::toRoute(['/order/index'])];
} else {
    $this->params['breadcrumbs'][] = ['label' => $restaurantName, 'url' => Url::toRoute(['restaurants/details', 'id' => $restaurant->id])];
}
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="restaurants-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Zmień', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Usuń', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            //'foodName',
            'foodInfo',
            'foodPrice',

        ],
    ]) ?>

    <p><?= Html::a('Zamów', ['order/uwagi', 'id' => $model->id], ['class' => 'btn btn-primary']) ?></p>

    <h3><?= Yii::t('app', 'Ostatnie zamówienia') ?></h3>
    <?= GridView::widget([
        'dataProvider' => $lastOrdersProvider,
        'summary' => '',
        'tableOptions' => ['class' => 'table  table-bordered table-hover'],
        'columns' => [
            ['class' => SerialColumn::class],
            [
                'attribute' => 'user.username',
                'enableSorting' => false,
                'filter' => false
            ],
            [
                'attribute' => 'uwagi',
                'enableSorting' => false,
                'filter' => false
            ],
            [
                'attribute' => 'data',
                'enableSorting' => false,
                'filter' => false
            ],
            ['class' => ActionColumn::class,
                'template' => '{again}',
                'buttons' => [
                    'again' => function ($url, $model, $key) {
                        return \yii\helpers\Html::a(
                            ' <span class="material-icons">restaurant</span>',
                            Url::to(['/order/again', 'id' => $model->id]),
                            ['title' => Yii::t('app', 'Smakowało? Zamów raz jeszcze!')]
                        );
                    }
                ],
                'contentOptions' => ['class' => 'text-center',
                ],
            ],
        ],
    ]);
        ?>

</div>
