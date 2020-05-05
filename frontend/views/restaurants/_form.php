<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use frontend\models\Restaurants;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\Restaurants */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="restaurants-form">

    <?php  $form = ActiveForm::begin(['options' => [
                        'layout' => 'horizontal',
                        'fieldConfig' => [
                            'template' => "{label}\n<div class=\"col-md-10\">{input}</div>\n<div class=\"col-md-offset-2 col-md-10\">{error}</div>",
                        ],
            ]])
?>

            <?= $form->field($model, 'restaurantName', ['labelOptions' => ['class' => 'control-label col-md-3']])->textInput(['style' => 'width:300px']); ?>


    <?=
        $form->field($model, 'tel_number', ['labelOptions' => ['class' => 'control-label col-md-3']])->widget(MaskedInput::className(), [
            'mask' => ['29999-99-99', '999-999-999', ],
        ]);
?>


    <?=
        $form->field($model, 'delivery_price', ['labelOptions' => ['class' => 'control-label col-md-3']])->widget(MaskedInput::className(), [
            'clientOptions' => [
                'alias' => 'decimal',
                'groupSeparator' => '',
                'autoGroup' => true
            ],
        ]);
?>
        <?=
        $form->field($model, 'pack_price', ['labelOptions' => ['class' => 'control-label col-md-3']])->widget(MaskedInput::className(), [
            'clientOptions' => [
                'alias' => 'decimal',
                'groupSeparator' => '',
                'autoGroup' => true
            ],
        ]);
?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Daodaj' : 'Edytuj', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
