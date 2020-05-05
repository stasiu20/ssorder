<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TestowaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Testowas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="testowa-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Testowa', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nazwa',
            'adres',
            'status',

            ['class' => \common\widgets\grid\ActionMaterialIconColumn::class],
        ],
    ]); ?>
</div>
