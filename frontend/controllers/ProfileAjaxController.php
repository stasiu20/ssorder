<?php

namespace frontend\controllers;

use common\models\User;
use common\resources\UserProfileResource;
use League\Fractal\Manager;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\Response;

class ProfileAjaxController extends Controller
{
    public function behaviors()
    {
        return [
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbFilter' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'update-profile' => ['POST'],
                ],
            ],
        ];
    }

    public function actionUpdateProfile()
    {
        /** @var User $user */
        $user = \Yii::$app->user->identity;
        if (!$user->load(\Yii::$app->request->post(), '')) {
            throw new BadRequestHttpException('Bad JSON');
        }

        if ($user->save()) {
            /** @var Manager $fractalManager */
            $fractalManager = \Yii::$container->get(Manager::class);
            return $fractalManager->createData(UserProfileResource::factoryItem($user))->toArray();
        }

        return $user;
    }
}
