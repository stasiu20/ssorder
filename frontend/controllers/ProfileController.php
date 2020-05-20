<?php

namespace frontend\controllers;

use common\models\User;
use common\transformers\UserProfileTransformer;
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

        /** @var UserProfileTransformer $transformer */
        $transformer = \Yii::$container->get(UserProfileTransformer::class);

        return $this->render('index', [
            'user' => $user,
            'userData' => $transformer->transform($user),
        ]);
    }
}
