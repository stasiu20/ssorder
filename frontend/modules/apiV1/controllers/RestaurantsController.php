<?php

namespace frontend\modules\apiV1\controllers;

use common\resources\RestaurantResource;
use frontend\models\Restaurants;
use frontend\modules\apiV1\models\Food;
use League\Fractal\Manager;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use \OpenApi\Annotations as OA;

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
     * @OA\Get(
     *      path="/restaurants",
     *      operationId="getRestaurantsList",
     *      tags={"Restaurants"},
     *      summary="Get list of restaurants",
     *      description="Returns list of restaurants",
     *      security={{"jwtToken": {}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/Restaurant"),
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
    public function actionIndex(): array
    {
        $restaurants = Restaurants::findActiveRestaurants()->all();

        /** @var Manager $fractalManager */
        $fractalManager = Yii::$container->get(Manager::class);
        return $fractalManager->createData(RestaurantResource::factoryCollection($restaurants))->toArray();
    }

    /**
     * @OA\Get(
     *     path="/restaurants/{restaurantId}/foods",
     *     operationId="getRestaurantFoodsList",
     *     tags={"Restaurants"},
     *     summary="Get list of foods in restaurant",
     *     description="Returns list of foods in restaurant",
     *     security={{"jwtToken": {}}},
     *     @OA\Parameter(
     *         name="restaurantId",
     *         description="Restaurant id",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Food"),
     *         )
     *      ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *      ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found"
     *     )
     * )
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
