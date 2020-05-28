<?php

namespace frontend\controllers;

use frontend\models\Restaurants;
use yii\rest\Controller;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
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
                    'update' => ['POST'],
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

    public function actionUpdate(int $id)
    {
        $model = $this->findModel($id);
        $model->scenario = Restaurants::SCENARIO_UPDATE;

        if (!$model->load(\Yii::$app->request->post(), '')) {
            throw new BadRequestHttpException('Bad JSON');
        }
        $model->save();
        return $model;
    }

    /**
     * Finds the Restaurants model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Restaurants the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): Restaurants
    {
        if (($model = Restaurants::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
