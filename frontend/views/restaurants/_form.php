<?php

use frontend\models\Category;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model \frontend\models\Restaurants */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="restaurants-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'restaurantName')->textInput(); ?>

    <?= $form->field($model, 'tel_number')->widget(MaskedInput::className(), [
        'mask' => ['29999-99-99', '999-999-999',],
    ]); ?>

    <?= $form->field($model, 'delivery_price')->widget(MaskedInput::className(), [
        'clientOptions' => [
            'alias' => 'decimal',
            'groupSeparator' => '',
            'autoGroup' => true
        ],
    ]); ?>

    <?= $form->field($model, 'pack_price')->widget(MaskedInput::className(), [
        'clientOptions' => [
            'alias' => 'decimal',
            'groupSeparator' => '',
            'autoGroup' => true
        ],
    ]); ?>

    <?= $form->field($model, 'categoryId')
        ->dropdownList(
            ArrayHelper::map(Category::find()->all(), 'id', 'categoryName'),
            ['prompt' => '---Wybierz Kategorię---']
        ) ?>

    <?php if (!$model->isNewRecord): ?>
        <?= \common\widgets\VaadinUpload::widget([
            'target' => \yii\helpers\Url::to(['/upload/restaurant-logo', 'id' => $model->id]),
            'accept' => 'image/*',
            'maxFiles' => 1,
            'formDataName' => 'imageFile'
        ]) ?>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton(
            $model->isNewRecord ? 'Dodaj' : 'Edytuj',
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
