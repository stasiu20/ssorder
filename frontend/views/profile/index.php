<?php
/** @var $user \common\models\User */
?>

<div class="profile-form">
    <?php $form = \yii\bootstrap4\ActiveForm::begin(); ?>
    <?= $form->field($user, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($user, 'rocketchat_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($user, 'new_password')->passwordInput(['maxlength' => true, 'autocomplete' => 'new-password']) ?>

    <div class="form-group">
        <?= \yii\bootstrap4\Html::submitButton(Yii::t('app', 'Aktualizuj'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php \yii\bootstrap4\ActiveForm::end(); ?>
</div>
