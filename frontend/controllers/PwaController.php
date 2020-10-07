<?php

namespace frontend\controllers;

use yii\web\Controller;

class PwaController extends Controller
{
    public $layout = 'pwa.php';

    public function actionIndex()
    {
        return $this->render('index');
    }
}
