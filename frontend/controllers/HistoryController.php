<?php

namespace frontend\controllers;

use common\models\History;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;

class HistoryController extends Controller
{
    public function behaviors() {

        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['my'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionMy()
    {
        $userId = \Yii::$app->user->identity->id;
        $dataProvider = new ActiveDataProvider([
            'query' => History::findByUser($userId),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('user', [
            'dataProvider' => $dataProvider,
        ]);
    }
}
