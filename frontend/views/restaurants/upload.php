<?php

use yii\widgets\ActiveForm;
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
                'autoGroup' => true,
                
            ],
        ]);
?>
        <?= $form->field($model, 'categoryId', ['labelOptions' => ['class' => 'control-label col-md-3']])->dropdownList(ArrayHelper::map(Category::find()->all(), 'id', 'categoryName'), ['prompt' => '---Wybierz Kategorię---', 'style' => 'width:200px']) ?>
        <?=
        $form->field($model, 'imageFile', ['labelOptions' => ['class' => 'control-label col-md-3']])->widget(FileInput::classname(), [
            'options' => ['accept' => 'image/*',
                'class'=>'file-loading',
                
                
                           
                ],
          
        ]);
?>
        <button class="btn btn-custom">Dodaj Restaurację</button>
        <?php ActiveForm::end(); ?>       
    </div>
    <div class="col-lg-4"></div>
</div>

<?php
//$form->field($model, 'tel_number') ?>

