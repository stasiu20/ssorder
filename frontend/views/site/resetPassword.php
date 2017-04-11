<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Zmień hasło';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-reset-password">


    <div class="row">
        <div class="col-lg-5"></div>
        <div class="col-lg-5">
            <h1><?= Html::encode($this->title) ?></h1>

            <p>Wybierz nowe hasło:</p>
            <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

            <?= $form->field($model, 'password')->passwordInput(['autofocus' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton('Zapisz', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
