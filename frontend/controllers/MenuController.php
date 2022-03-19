<?php

namespace frontend\controllers;

use common\models\History;
use common\models\Order;
use common\models\OrderFilters;
use common\models\OrderSearch;
use frontend\models\Menu;
use frontend\models\Restaurants;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class MenuController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @param $id int
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $menu = $this->findModel($id);
        $restaurant = $menu->restaurant;
        $filters = new OrderFilters();
        $filters->status = Order::STATUS_REALIZED;
        $filters->foodId = $id;
        $lastOrdersProvider = new ActiveDataProvider([
            'query' => OrderSearch::search($filters),
            'pagination' => new Pagination(),
            'sort' => History::getDefaultSort()
        ]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'restaurant' => $restaurant,
            'lastOrdersProvider' => $lastOrdersProvider
        ]);
    }


    /**
     * @param $id int
     * @return string|\yii\web\Response
     */
    public function actionCreate($id)
    {
        $model = new Menu();
        $restaurant = Restaurants::findOne($id);
        if (!$restaurant) {
            throw new NotFoundHttpException();
        }

        $model->restaurantId = $id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['restaurants/details', 'id' => $restaurant->id]);
        }
        return $this->render('create', [
            'model' => $model,
            'restaurant' => $restaurant,
        ]);
    }

    /**
     * @param $id int
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $menu = $model;
        $restaurant = $menu->restaurant;
        return $this->render('update', [
            'model' => $model,
            'restaurant' => $restaurant,
        ]);
    }

    /**
     * @param $id int
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        $menu = $this->findModel($id);
        $restaurant = $menu->restaurant;
        $menu->softDelete();
        return $this->redirect(['restaurants/details', 'id' => $restaurant->id]);
    }

    /**
     * @param $id int
     * @return Menu
     * @throws NotFoundHttpException
     */
    protected function findModel($id): Menu
    {
        if (($model = Menu::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
