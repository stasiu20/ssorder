<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\Menu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="restaurants-form">

    <?php
    $form = ActiveForm::begin(['options' => [
                    'layout' => 'horizontal',
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-md-10\">{input}</div>\n<div class=\"col-md-offset-2 col-md-10\">{error}</div>",
                    ],
    ]]);
    ?>



    <?= $form->field($model, 'foodName', ['labelOptions' => ['class' => 'control-label col-md-3']])->textInput(['style' => 'width:300px']) ?>

    <?= $form->field($model, 'foodInfo', ['labelOptions' => ['class' => 'control-label col-md-3']])->textarea(['style' => 'width:300px']) ?>
    <?=
    $form->field($model, 'foodPrice', ['labelOptions' => ['class' => 'control-label col-md-3']])->widget(MaskedInput::className(), [

        'clientOptions' => [
            'alias' => 'decimal',
            'groupSeparator' => '',
            'autoGroup' => true,
            
        ],
        'options'=>[
            'style'=>'width:80px',
            'class' => 'form-control',
            
        ]
    ]);
?>

    



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Dodaj' : 'Edytuj', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end(); ?>

</div>
