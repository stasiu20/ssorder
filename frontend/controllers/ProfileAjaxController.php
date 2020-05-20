<?php

namespace frontend\controllers;

use common\models\User;
use common\transformers\UserProfileTransformer;
use yii\base\Controller;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
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
            /** @var UserProfileTransformer $transformer */
            $transformer = \Yii::$container->get(UserProfileTransformer::class);
            return $transformer->transform($user);
        }

        return $user;
    }
}
