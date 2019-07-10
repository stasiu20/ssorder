<?php

namespace frontend\modules\apiV1\controllers;

use frontend\models\Restaurants;
use frontend\modules\apiV1\models\Restaurant;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\rest\Controller;

class RestaurantsController extends Controller
{
    public function behaviors()
    {
        $parent = parent::behaviors();
        $parent['verbFilter']['actions'] = [
            'index' => ['get'],
        ];
        $parent['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                ['actions' => ['index'], 'allow' => true, 'roles' => ['@']],
            ]
        ];
        return $parent;
    }

    public function actionIndex()
    {
        $restaurants = Restaurants::findActiveRestaurants();
        $restaurants->modelClass = Restaurant::class;
        return new ActiveDataProvider([
            'query' => $restaurants
        ]);
    }
}
