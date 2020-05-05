<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use frontend\models\Category;
use frontend\models\Restaurants;
use kartik\file\FileInput;
use borales\extensions\phoneInput\PhoneInput;
use yii\widgets\MaskedInput;

$this->title = 'Dodaj Restaurację';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-2"></div>
    <div class="col-lg-8">

        <?php
        $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data',
            ]])
        ?>

        <?= $form->field($model, 'restaurantName')->textInput(); ?>

        <?=
        $form->field($model, 'tel_number')->widget(MaskedInput::className(), [
            'mask' => ['29999-99-99', '999-999-999', ],
        ]);
?>
        <?=
        $form->field($model, 'delivery_price')->widget(MaskedInput::className(), [
            'clientOptions' => [
                'alias' => 'decimal',
                'groupSeparator' => '',
                'autoGroup' => true
            ],
        ]);
?>
        <?=
        $form->field($model, 'pack_price')->widget(MaskedInput::className(), [
            'clientOptions' => [
                'alias' => 'decimal',
                'groupSeparator' => '',
                'autoGroup' => true,

            ],
        ]);
?>
        <?= $form->field($model, 'categoryId')->dropdownList(ArrayHelper::map(Category::find()->all(), 'id', 'categoryName'), ['prompt' => '---Wybierz Kategorię---']) ?>
        <?=
        $form->field($model, 'imageFile')->widget(FileInput::classname(), [
            'options' => [
                    'accept' => 'image/*',
                    'class'=>'file-loading',
            ],
        ]);
?>
        <button class="btn btn-primary">Dodaj Restaurację</button>
        <?php ActiveForm::end(); ?>
    </div>
    <div class="col-lg-4"></div>
</div>
