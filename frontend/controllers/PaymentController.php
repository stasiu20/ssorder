<?php

namespace frontend\controllers;

use common\models\Order;
use common\models\OrderFilters;
use common\models\OrderSearch;
use frontend\services\OrderSummaryStatics;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;

class PaymentController extends Controller
{
    public function behaviors()
    {

        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['manage'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionManage()
    {
        $date = \DateTimeImmutable::createFromFormat('Y-m-d', date('Y-m-d'));
        $tomorrow = $date->add(new \DateInterval('P1D'));
        $userId = \Yii::$app->getUser()->identity->id;

        $filters = new OrderFilters();
        $filters->status = Order::STATUS_REALIZED;
        $filters->dateFrom = $date->format('Y-m-d');
        $filters->dateTo = $tomorrow->format('Y-m-d');
        $filters->realizedBy = $userId;

        $dp = OrderSearch::search($filters);
        /** @var Order[] $orders */
        $orders = $dp->all();

        if (\Yii::$app->request->isPost) {
            $data = \Yii::$app->request->post('price', []);
            \common\models\Payment::updatePayAmountFromPostData($orders, $data);
            foreach ($orders as $order) {
                if (strlen($order->pay_amount) > 0 && $order->validate(['pay_amount'])) {
                    $order->save(false, ['pay_amount']);
                }
            }
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $orders,
            'pagination' => [
                'defaultPageSize' => 100,
            ],
        ]);

        $statics = new OrderSummaryStatics();
        $summary = $statics->getStatics($orders);

        return $this->render('manage', [
            'dataProvider' => $dataProvider,
            'summary' => $summary,
        ]);
    }
}
