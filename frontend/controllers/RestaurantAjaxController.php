<?php

namespace frontend\controllers;

use frontend\models\Restaurants;
use yii\rest\Controller;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Response;

class RestaurantAjaxController extends Controller
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
                    'create' => ['POST'],
                ],
            ],
        ];
    }

    public function actionCreate()
    {
        $model = new Restaurants();
        $model->scenario = Restaurants::SCENARIO_UPDATE;

        if (!$model->load(\Yii::$app->request->post(), '')) {
            throw new BadRequestHttpException('Bad JSON');
        }
        $model->save();
        return $model;
    }
}
