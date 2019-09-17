<?php

namespace frontend\controllers;

use common\models\User;
use yii\filters\AccessControl;
use yii\web\Controller;

class ProfileController extends Controller
{
    public function behaviors()
    {

        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index',],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        /** @var User $user */
        $user = \Yii::$app->user->identity;

        if (\Yii::$app->request->isPost) {
            if ($user->load(\Yii::$app->request->post()) && $user->save()) {
                \Yii::$app->getSession()->setFlash('success', ' Your Profile has been saved.');
            }
        }

        return $this->render('index', [
            'user' => $user
        ]);
    }
}
