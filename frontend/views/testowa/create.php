<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Testowa */

$this->title = 'Create Testowa';
$this->params['breadcrumbs'][] = ['label' => 'Testowas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="testowa-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
