<?php

namespace frontend\controllers;

use common\enums\BucketEnum;
use common\services\FileService;
use frontend\helpers\FileServiceViewHelper;
use Yii;
use frontend\models\Restaurants;
use frontend\models\RestaurantsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

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
                'only' => ['index', 'delete', 'update', 'create'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'index', 'update', 'delete', 'create'],
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

    /**
     * Lists all Restaurants models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RestaurantsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Restaurants model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
                    'model' => $this->findModel($id),
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
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
        $model->scenario = 'update';
        $model->load(Yii::$app->request->post());
//        var_dump($model);die;

        $model->validate();
//    var_dump($model->validate(), $model->errors);die;
        $model->save();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['site/restaurant', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
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
            $menus->delete();
        }
        /** @var FileService $fileService */
        $fileService = Yii::$container->get(FileService::class);
        /** @var  $imgs */
        $imgs = $restaurant->imagesmenu;

        foreach ($imgs as $img) {
            $fileService->deleteFile(FileServiceViewHelper::getMenuImageKey($img->imagesMenu_url));
            $img->delete();
        }
        $fileService->deleteFile(FileServiceViewHelper::getRestaurantImageKey($restaurant->img_url));
        $restaurant->delete();
        return $this->redirect(['site/index']);
    }

    public function actionUpload()
    {
        $model = new Restaurants();
        $model->scenario = 'upload';
        $model->load(\Yii::$app->request->post());

        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            $key = $model->getTmpFileKey();
            $model->img_url = $key;
            if ($model->validate()) {
                /** @var FileService $fileService */
                $fileService = Yii::$container->get(FileService::class);
                $fileService->storeFile(
                    BucketEnum::RESTAURANT . '/' . $key,
                    $model->imageFile->tempName
                );
                $model->save(false);
                return $this->redirect(['index']);
            }
        }

        return $this->render('upload', ['model' => $model,
        ]);
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
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
