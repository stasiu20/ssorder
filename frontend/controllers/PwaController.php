<?php

namespace frontend\controllers;

use yii\web\Controller;

class PwaController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
