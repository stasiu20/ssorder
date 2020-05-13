<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Zmiana hasła';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-request-password-reset">


    <div class="row">
        <div class="col-lg-4"></div>
        <div class="col-lg-5">
            <h1><?= Html::encode($this->title) ?></h1>

            <p>Podaj maila na którego mam wysłać link do zmiany hasła.</p>
            <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

            <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton('Ślij', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
