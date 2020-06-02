<?php

namespace frontend\controllers;

use common\models\User;
use common\resources\UserProfileResource;
use League\Fractal\Manager;
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

        /** @var Manager $fractalManager */
        $fractalManager = \Yii::$container->get(Manager::class);
        $userData = $fractalManager->createData(UserProfileResource::factoryItem($user))->toArray();

        return $this->render('index', [
            'user' => $user,
            'userData' => $userData,
        ]);
    }
}
