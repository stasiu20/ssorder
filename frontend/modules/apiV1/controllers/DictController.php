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

    /**
     * @OA\Get(
     *      path="/dict/categories",
     *      operationId="getRestaurantCategories",
     *      tags={"Dict"},
     *      summary="Get dict of restaurant categories",
     *      description="Returns dict of restaurant categories",
     *      security={{"jwtToken": {}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/RestaurantCategory"),
     *          )
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public function actionCategories()
    {
        /** @var Category[] $categories */
        $categories = Category::findActive()->all();

        /** @var Manager $fractalManager */
        $fractalManager = Yii::$container->get(Manager::class);
        return $fractalManager->createData(DictResource::factoryRestaurantCategoryCollection($categories))->toArray();
    }
}
