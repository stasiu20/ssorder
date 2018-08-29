<?php

namespace frontend\controllers;

use common\models\History;
use common\models\OrderFilters;
use common\models\OrderSearch;
use frontend\models\Imagesmenu;
use frontend\models\Restaurants;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
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
                        'actions' => ['my', 'restaurant'],
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
            'sort' => History::getDefaultSort(),
            'pagination' => new Pagination(),
        ]);

        return $this->render('user', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRestaurant($id)
    {
        $restaurant = Restaurants::findOne($id);
        $imagesMenu = Imagesmenu::find()->where(['restaurantId' => $id])->all();
        $filters = new OrderFilters();
        $filters->restaurantId = $id;

        $dataProvider = new ActiveDataProvider([
            'query' => OrderSearch::search($filters),
            'sort' => History::getDefaultSort(),
            'pagination' => new Pagination()
        ]);


        return $this->render('restaurant', [
            'restaurant' => $restaurant,
            'imagesMenu' => $imagesMenu,
            'dataProvider' => $dataProvider,
        ]);
    }
}
