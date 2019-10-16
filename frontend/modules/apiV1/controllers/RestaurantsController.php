<?php

namespace frontend\modules\apiV1\controllers;

use frontend\models\Restaurants;
use frontend\modules\apiV1\models\Food;
use frontend\modules\apiV1\models\Restaurant;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;

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
                ['actions' => ['index', 'foods'], 'allow' => true, 'roles' => ['@']],
            ]
        ];
        return $parent;
    }

    /**
     * @return ActiveDataProvider
     */
    public function actionIndex()
    {
        $restaurants = Restaurants::findActiveRestaurants();
        $restaurants->modelClass = Restaurant::class;
        return new ActiveDataProvider([
            'query' => $restaurants
        ]);
    }

    /**
     * @param int $restaurantId
     * @return ActiveDataProvider
     * @throws NotFoundHttpException
     */
    public function actionFoods(int $restaurantId)
    {
        $restaurant = Restaurants::findOne($restaurantId);
        if (null === $restaurant) {
            throw new NotFoundHttpException('Restaurant not exists');
        }

        $foods = $restaurant->getMenu();
        $foods->modelClass = Food::class;
        return new ActiveDataProvider([
            'query' => $foods
        ]);
    }
}
