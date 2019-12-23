<?php

use common\models\FoodRating;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this \yii\web\View */
/* @var $model FoodRating */
?>
<div>
    <?php $form = ActiveForm::begin() ?>
    <?= $form->field($model, 'rating')->input('number') ?>
    <?= $form->field($model, 'review')->textarea() ?>

    <div class="form-group">
        <?= Html::submitButton(
            $model->isNewRecord ? Yii::t('app', 'Dodaj') : Yii::t('app', 'Edytuj'),
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
