<?php

use frontend\models\Menu;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model Menu */
$url = 'site/restaurant?id=' . $model->restaurant->id;
$this->title = 'Zamówienie: ' . $model->foodName;
$this->params['breadcrumbs'][] = ['label' => $model->restaurant->restaurantName, 'url' => [$url]];

$this->params['breadcrumbs'][] = 'Uwagi';
?>
<div class="restaurants-update">
    <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-6">
            <h1><?= Html::encode($this->title) ?></h1>
            <h4>Cena: <?php echo $model->foodPrice ?>zł</h4>
            <?=
            $this->render('_formUwagi', [
                'model' => $model,
                'order' => $order,
            ])
                        ?>
        </div>
        <div class="col-lg-2"></div>
    </div>
</div>
