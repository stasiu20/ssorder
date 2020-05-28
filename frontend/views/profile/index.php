<?php
/** @var $user \common\models\User */
/** @var $userData array */
/** @var $this \yii\web\View */

\frontend\assets\ProfileAsset::register($this);
$this->registerJsVar('__APP_DATA__', ['userData' => $userData])
?>
<div id="react-profile"></div>
