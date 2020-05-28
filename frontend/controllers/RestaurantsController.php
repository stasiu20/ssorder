<?php

namespace frontend\controllers;

use common\services\FileService;
use common\transformers\RestaurantCollectionTransformer;
use frontend\helpers\FileServiceViewHelper;
use frontend\models\Category;
use frontend\models\Imagesmenu;
use frontend\models\Menu;
use frontend\models\Restaurants;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * RestaurantsController implements the CRUD actions for Restaurants model.
 */
class RestaurantsController extends Controller
{
    /**
     * @inheritdoc
     */
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
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $query = Restaurants::findActiveRestaurants();
        $restaurants = $query->orderBy('restaurantName')->all();
        $categorys = Category::findActive()->all();
        return $this->render('index', [
            'restaurants' => $restaurants,
            'categorys' => $categorys,
            'transformer' => Yii::$container->get(RestaurantCollectionTransformer::class),
        ]);
    }

    /**
     * @param $id int
     * @return string
     */
    public function actionDetails($id)
    {
        $restaurant = $this->findModel($id);
        $imagesMenu = Imagesmenu::find()->where(['restaurantId' => $id])->all();
        $menu = $restaurant->menu;
        $restaurants = Restaurants::find()->all();
        $model = new Imagesmenu();
        $dataProvider = new ActiveDataProvider([
            'query' => Menu::find()->where(['restaurantId' => $id])->andWhere(['deletedAt' => null]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('restaurant', [
            'restaurant' => $restaurant,
            'menu' => $menu,
            'dataProvider' => $dataProvider,
            'restaurants' => $restaurants,
            'model' => $model,
            'imagesMenu' => $imagesMenu,
        ]);
    }

    /**
     * Creates a new Restaurants model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Restaurants();
        $model->scenario = Restaurants::SCENARIO_UPDATE;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['restaurants/update', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Restaurants model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = Restaurants::SCENARIO_UPDATE;
        $model->load(Yii::$app->request->post());
        $model->validate();
        $model->save();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['restaurants/details', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Restaurants model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $restaurant = $this->findModel($id);
        $menu = $restaurant->menu;
        foreach ($menu as $menus) {
            $menus->softDelete();
        }
        /** @var FileService $fileService */
        $fileService = Yii::$container->get(FileService::class);
        /** @var  $imgs */
        $imgs = $restaurant->imagesmenu;
        foreach ($imgs as $img) {
            $fileService->deleteFile(FileServiceViewHelper::getMenuImageKey($img->imagesMenu_url));
            $img->softDelete();
        }
        $fileService->deleteFile(FileServiceViewHelper::getRestaurantImageKey($restaurant->img_url));
        $restaurant->softDelete();
        return $this->redirect(['restaurants/index']);
    }

    /**
     * @param $id int Image id
     * @return \yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDeleteImage(int $id)
    {
        $img = Imagesmenu::findOne($id);
        if (!$img) {
            throw new NotFoundHttpException();
        }

        $img->delete();
        /** @var FileService $fileService */
        $fileService = Yii::$container->get(FileService::class);
        $fileService->deleteFile(
            FileServiceViewHelper::getMenuImageKey($img->imagesMenu_url)
        );
        return $this->redirect(['restaurants/details', 'id' => $img->restaurantId]);
    }

    /**
     * Finds the Restaurants model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Restaurants the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Restaurants::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
