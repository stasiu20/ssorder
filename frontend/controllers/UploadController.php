<?php

namespace frontend\controllers;

use common\enums\BucketEnum;
use common\services\actions\UploadRestaurantLogo;
use common\services\FileService;
use frontend\models\Imagesmenu;
use frontend\models\Restaurants;
use yii\filters\AccessControl;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class UploadController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'denyCallback' => function () {
                throw new ForbiddenHttpException(\Yii::t('yii', 'You are not allowed to perform this action.'));
            },
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ];
        return $behaviors;
    }

    protected function verbs()
    {
        return [
            'restaurant-logo' => ['POST'],
            'image' => ['POST'],
        ];
    }

    public function actionRestaurantLogo($id)
    {
        $model = $this->findRestaurantModel($id);

        /** @var UploadRestaurantLogo $uploadRestaurantLogoAction */
        $uploadRestaurantLogoAction =\Yii::$container->get(UploadRestaurantLogo::class);
        $uploadFile = UploadedFile::getInstanceByName('imageFile');
        if (!$uploadFile) {
            throw new BadRequestHttpException('Uploaded file not found');
        }
        $uploadRestaurantLogoAction->run($model, $uploadFile);
        $model->save();
        return $model;
    }

    public function actionImage($id)
    {
        $model = new Imagesmenu();
        $restaurant = $this->findRestaurantModel($id);
        $model->restaurantId = $restaurant->id;
        $model->imageFile = UploadedFile::getInstanceByName('imagesMenu_url');
        if ($model->validate()) {
            /** @var FileService $fileService */
            $fileService = \Yii::$container->get(FileService::class);
            $key = $model->getTmpFileKey();
            $fileService->storeFile(BucketEnum::MENU . '/' . $key, $model->imageFile->tempName);
            $model->imagesMenu_url = $key;
            $model->save(false);
        }
        return $model;
    }

    /**
     * Finds the Restaurants model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Restaurants the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findRestaurantModel($id)
    {
        if (($model = Restaurants::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
