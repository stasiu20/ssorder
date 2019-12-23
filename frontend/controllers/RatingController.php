<?php

namespace frontend\controllers;

use common\models\FoodRating;
use common\models\Order;
use common\services\actions\CreateFoodRating;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class RatingController extends Controller
{
    public function behaviors()
    {

        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['order'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionOrder(int $orderId)
    {
        $order = Order::findOne($orderId);
        if (!$order) {
            throw new NotFoundHttpException();
        }

        if ($order->userId !== \Yii::$app->user->identity->getId()) {
            throw new ForbiddenHttpException();
        }

        $rating = new FoodRating();
        if (\Yii::$app->request->isPost) {
            $rating->load(\Yii::$app->request->post());
            $rating->order_id = $order->id;
            if ($rating->validate(['review', 'rating', 'order_id'])) {
                /** @var CreateFoodRating $service */
                $service = \Yii::$container->get(CreateFoodRating::class);
                $service->run(\Yii::$app->user->identity, $order, $rating->rating, $rating->review);
                $this->redirect(['history/my']);
            }
        }

        return $this->render('order', [
            'model' => $rating,
        ]);
    }
}
