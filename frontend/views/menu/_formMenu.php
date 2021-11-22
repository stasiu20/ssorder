<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model \frontend\models\Menu */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="restaurants-form">

    <?php
    $form = ActiveForm::begin();
    ?>

    <?= $form->field($model, 'foodName')->textInput() ?>

    <?= $form->field($model, 'foodInfo')->textarea() ?>
    <?=
    $form->field($model, 'foodPrice')->widget(MaskedInput::className(), [
        'clientOptions' => [
            'alias' => 'decimal',
            'groupSeparator' => '',
            'autoGroup' => true,
        ],
    ]);
    ?>





    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Dodaj' : 'Edytuj', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end(); ?>

</div>
