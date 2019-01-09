<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\Restaurants;

/* @var $this yii\web\View */
/* @var $model app\models\Restaurants */
/* @var $form yii\widgets\ActiveForm */
/* @var $action string|null */
?>

<div class="restaurants-form">
    
    
    

    <?php $form = ActiveForm::begin(['action' => isset($action) ? $action : null]); ?>

    <?= $form->field($order, 'uwagi')->textarea(['rows' => 6], ['palceholder'=>$order->uwagi]) ?>
    
    <?php if (!$order->isNewRecord): ?> 
        <?= $form->field($order, 'orderId')->hiddenInput(['value'=> $order->id])->label(false); ?>
    <?php endif; ?>
    

    <div class="form-group">
        <?= Html::submitButton($order->isNewRecord ? 'Zamów' : 'Zapisz zmiany', ['class' => $order->isNewRecord ? 'btn btn-primary' : 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
