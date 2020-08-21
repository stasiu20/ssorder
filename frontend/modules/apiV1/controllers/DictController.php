<?php

namespace frontend\modules\apiV1\controllers;

use common\resources\DictResource;
use frontend\models\Category;
use League\Fractal\Manager;
use Yii;
use yii\filters\AccessControl;
use yii\rest\Controller;

class DictController extends Controller
{
    public function behaviors(): array
    {
        $parent = parent::behaviors();
        $parent['verbFilter']['actions'] = [
            'categories' => ['get'],
        ];
        $parent['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                ['actions' => ['categories'], 'allow' => true, 'roles' => ['@']],
            ]
        ];
        return $parent;
    }

    public function actionCategories()
    {
        /** @var Category[] $categories */
        $categories = Category::findActive()->all();

        /** @var Manager $fractalManager */
        $fractalManager = Yii::$container->get(Manager::class);
        return $fractalManager->createData(DictResource::factoryRestaurantCategoryCollection($categories))->toArray();
    }
}
