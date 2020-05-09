<?php

use common\helpers\OrderView;
use common\models\Order;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var \DateTime $date */
/** @var \DateTime $yesterday */
/** @var \DateTime $tomorrow */
/** @var \DateTime $today */
/** @var \DateTime $minDate */
/** @var \DateTime $sevenDaysAgo */
/** @var \DateTime $sevenDaysNext */
/** @var mixed $orderCollection */
/** @var \frontend\models\OrdersSummary $summary */

$this->title = 'Zamówienia - ' . $date->format('Y-m-d');
$this->params['breadcrumbs'][] = $this->title;
?>
<h2 class="text-center mb-3">
    <?php if ($sevenDaysAgo >= $minDate): ?>
        <a href="<?= Url::to(['/order', 'date' => $sevenDaysAgo->format('Y-m-d')]); ?>">
            <span class="material-icons">fast_rewind</span></a>
    <?php endif ?>
    <?php if ($date > $minDate): ?>
        <a href="<?= Url::to(['/order', 'date' => $yesterday->format('Y-m-d')]) ?>"><span
                    class="material-icons">keyboard_arrow_left</span></a>
    <?php endif ?>
    Zamówienia z Dnia: <?= $date->format('d-m-Y') ?>
    <?php if ($tomorrow <= $today): ?>
        <a href="<?= Url::to(['/order', 'date' => $tomorrow->format('Y-m-d')]) ?>"><span
                    class="material-icons">keyboard_arrow_right</span></a>
    <?php endif; ?>
    <?php if ($sevenDaysNext <= $today): ?>
        <a href="<?= Url::to(['/order', 'date' => $sevenDaysNext->format('Y-m-d')]); ?>">
            <span class="material-icons">fast_forward</span>
        </a>
    <?php endif ?>
</h2>

<?php
$userId = Yii::$app->user->identity->id;
$formatter = \Yii::$app->formatter;
?>

<?php if (empty($orderCollection)): ?>
    <h2>Brak złożonych zamówień</h2>
    <h3><a href="<?= Url::toRoute(['/restaurants']) ?>">Przejdź do listy restauracji</a></h3>
<?php endif; ?>

<?php foreach ($orderCollection as $restaurantId => $orders): ?>
    <?php /** @var $orders Order[]  */ ?>
    <?php $summaryRow = $summary->getDataForRestaurant($restaurantId); ?>
<div class="accordion" id="accordionOrders">
    <div class="card">
        <div class="card-header order-card__header" id="panelHeaderRestaurant<?= $restaurantId ?>" data-toggle="collapse"
             data-target="#panelRestaurant<?= $restaurantId ?>">
            <h2>
                <a href="<?= Url::toRoute(['restaurants/details', 'id' => $orders[0]->menu->restaurant->id]) ?>"><?= $orders[0]->menu->restaurant->restaurantName ?></a>
            </h2>
            <div>
                <span class="order-card__label">CENA / DO ZAPŁATY / DO ROZLICZENIA:</span>
                <span class="order-card__value">
                    <?= $formatter->asCurrency($summaryRow->price) ?> /
                    <?= $formatter->asCurrency($summaryRow->getCostWithDelivery()) ?> /
                    <?= $formatter->asCurrency($summaryRow->change) ?>
                </span>
            </div>
            <div>
                <span class="order-card__label">Zamówień / Zrealizowanych</span>
                <span class="order-card__value"><?= $summaryRow->allOrders ?> / <?= $summaryRow->numOfRealizedOrders ?></span>
            </div>
            <div class="order-card__buttons">
                <?php if ($summaryRow->allOrders !== $summaryRow->numOfRealizedOrders): ?>
                    <?= Html::a('Zrealizuj', Url::toRoute(['/order/restaurant', 'id' => $restaurantId]), ['class' => 'btn btn-sm btn-primary']) ?>
                <?php endif; ?>
            </div>
        </div>

        <?php foreach ($orders as $order): ?>
            <?php
            $delete = ($userId === $order->userId ? Html::a('usuń', ['delete'], [
                'class' => 'btn btn-sm btn-danger',
                'data' => [
                    'confirm' => 'Jesteś pewien, że chcesz odmówić to zamówienie?',
                    'method' => 'post',
                    'params' => ['id' => $order->id]

                ],
            ]) : '');
            $edit = ($userId === $order->userId ? Html::a('edytuj', ['/order/edit', 'id' => $order->id], [
                'class' => 'btn btn-sm btn-secondary',
            ]) : '');
            ?>
            <div id="panelRestaurant<?= $restaurantId ?>" class="collapse show" data-parent="#accordionOrders">
                <div class="card-body order-card">
                    <div class="order-card__row">
                        <a class="text-truncate" href="<?= Url::toRoute(['menu/view', 'id' => $order->menu->id]) ?>"><?= $order->menu->foodName ?></a>
                        <div class="order-card__buttons">
                            <?php if ($order->isRealized()): ?>
                                <a title="Smakowało? Zamów raz jeszcze!" href="<?= Url::to(['/order/again', 'id' => $order->id]) ?>">
                                    <span class="material-icons">restaurant</span>
                                </a>
                            <?php else: ?>
                                <?= $delete . $edit ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="order-card__row">
                        <div>
                            <span class="order-card__label">Kto:</span>
                            <span class="order-card__value"><?= $order->user->username ?></span>
                        </div>
                        <div>
                            <span class="order-card__label">Status:</span>
                            <span style="color: <?= !$order->isRealized() ? 'red' : 'green' ?>">
                                <?= Yii::t('app', 'ORDER_STATUS_' . $order->status) ?>
                            </span>
                        </div>
                    </div>

                    <div class="order-card__row">
                        <div>
                            <span class="order-card__label">Cena:</span>
                            <span class="order-card__value"><?= $formatter->asCurrency($order->getPrice()) ?></span>
                        </div>
                        <div>
                            <span class="order-card__label">Do zapłaty:</span>
                            <span class="order-card__value"><?= $formatter->asCurrency($order->total_price) ?></span>
                        </div>
                        <div>
                            <span class="order-card__label">Do rozliczenia: </span>
                            <span class="order-card__value">
                                <?php if ($order->isRealized()): ?>
                                    <span class="<?= OrderView::getSettlementCssClass($order->paymentChange($order->total_price)) ?>">
                                    <span title="<?= OrderView::getOrderChangeTitle($order) ?>">
                                        <?= $formatter->asCurrency(abs($order->paymentChange($order->total_price))) ?>
                                    </span>
                                <?php else:
                                    echo $formatter->asCurrency(null) ?>
                                <?php endif ?>
                                </span>
                            </span>
                        </div>
                    </div>

                    <div>
                        <span class="d-inline-block mb-2 order-card__label font-weight-bold">Uwagi:</span>
                        <p class="order-card__remarks"><?= nl2br($order->uwagi) ?></p>
                    </div>

                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endforeach; ?>
