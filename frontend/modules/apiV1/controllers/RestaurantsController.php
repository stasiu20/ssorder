<?php

namespace frontend\modules\apiV1\controllers;

use frontend\models\Restaurants;
use frontend\modules\apiV1\models\Food;
use frontend\modules\apiV1\models\Restaurant;
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
     * @OA\Get(
     *     path="/restaurants/{restaurantId}/foods",
     *     operationId="getRestaurantFoodsList",
     *     tags={"Restaurants"},
     *     summary="Get list of foods in restaurant",
     *     description="Returns list of foods in restaurant",
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
