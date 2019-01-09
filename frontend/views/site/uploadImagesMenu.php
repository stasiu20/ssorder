<?php

use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
?>
<div class="row">
    <div class="col-lg-2"></div>
    <div class="col-lg-6">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

        <?=
        $form->field($model, 'imagesMenu_url')->widget(FileInput::classname(), [
            'options' => ['accept' => 'image/*'],
        ]);
?>

<?php ActiveForm::end() ?>
    </div>
    <div class="col-lg-4"></div>
</div>