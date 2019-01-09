<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Restaurants */
$request = Yii::$app->request;
$order = $request->get('order');

$url = $restaurant[0]['id'];
$restaurantName = $restaurant[0]['restaurantName'];
$this->title = $model->foodName;
$order == true ? $this->params['breadcrumbs'][] = ['label' => 'Zamówienia', 'url' => ['/order/index']] :  $this->params['breadcrumbs'][] = ['label' => "$restaurantName", 'url' => ["site/restaurant?id=$url"]];
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

</div>
