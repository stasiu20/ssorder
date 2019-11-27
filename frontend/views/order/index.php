<?php

use yii\helpers\Html;

/** @var \DateTime $date */
/** @var \DateTime $yesterday */
/** @var \DateTime $tomorrow */
/** @var \DateTime $today */
/** @var \DateTime $minDate */
/** @var \DateTime $sevenDaysAgo */
/** @var \DateTime $sevenDaysNext */
/** @var \common\models\Order $order */
/** @var \frontend\models\OrdersSummary $summary */

$this->title = 'Zamówienia - ' . $date->format('Y-m-d');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-xs-12 text-center">
        <h1>
            <?php if ($sevenDaysAgo >= $minDate): ?>
                <a href="<?= \yii\helpers\Url::to(['/order', 'date' => $sevenDaysAgo->format('Y-m-d')]); ?>">
                    <span class="glyphicon glyphicon-backward"></span></a>
            <?php endif ?>
            <?php if ($date > $minDate): ?>
                <a href="<?= \yii\helpers\Url::to(['/order', 'date' => $yesterday->format('Y-m-d')]) ?>"><span
                            class="glyphicon glyphicon-chevron-left"></span></a>
            <?php endif ?>
            Zamówienia z Dnia: <?= $date->format('d-m-Y') ?>
            <?php if ($tomorrow <= $today): ?>
                <a href="<?= \yii\helpers\Url::to(['/order', 'date' => $tomorrow->format('Y-m-d')]) ?>"><span
                            class="glyphicon glyphicon-chevron-right"></span></a>
            <?php endif; ?>
            <?php if ($sevenDaysNext <= $today): ?>
                <a href="<?= \yii\helpers\Url::to(['/order', 'date' => $sevenDaysNext->format('Y-m-d')]); ?>">
                    <span class="glyphicon glyphicon-forward"></span>
                </a>
            <?php endif ?>
        </h1>
    </div>
</div>
<?php
$userName = Yii::$app->user->identity->username;

$formatter = \Yii::$app->formatter;
?>
<p>sortuj według: <?= $sort->link('restaurant'); ?></p>
<table class="table table-striped">
    <thead>
    <th>l.p.</th>
    <th>Nazwa Żarcia</th>
    <th>Nazwa Restauracji</th>
    <th>Cena</th>
    <th title="Do zapłaty (cena żarca wraz z opakowaniem i dowozem)">Do zapłaty</th>
    <th>Uwagi</th>
    <th>Kto Zamawia</th>
    <th>Status</th>
    <th>Do rozliczenia</th>
    <th>Akcje</th>
    </thead>
    <tbody>
    <?php
    $mapIndex = [];
    $i = 0;
    foreach ($model as $order):
        ++$i;
        if (!isset($mapIndex[$order->restaurantId])) {
            $mapIndex[$order->restaurantId] = -1;
        }
        $mapIndex[$order->restaurantId] += 1;
        $delete = ($userName === $order->user['username'] ? Html::a('usuń', ['delete'], [
            'class' => 'btn btn-custom',
            'style' => 'margin-right:10px',
            'data' => [
                'confirm' => 'Jesteś pewien, że chcesz odmówić to zamówienie?',
                'method' => 'post',
                'params' => ['id' => $order->id]

            ],
        ]) : '');
        $edit = ($userName == $order->user['username'] ? Html::a('edytuj', ['edit'], [
            'class' => 'btn btn-custom',
            'style' => 'margin-right:10px',
            'data' => [
                'method' => 'post',
                'params' => ['name' => Yii::$app->user->identity->username, 'id' => $order->id],

            ]
        ]) : '');
        $takeRestaurantId = $order->menu->restaurant->id;
        ?>

        <tr>
            <td><?= $i; ?></td>
            <td><a href="/site/view?id=<?= $order->menu->id ?>&order=true"><?= $order->menu->foodName ?></a></td>
            <td>
                <a href="/site/restaurant?id=<?= $order->menu->restaurant->id ?>"><?= $order->menu->restaurant->restaurantName ?></a>
            </td>
            <td><?= $formatter->asCurrency($order->getPrice()) ?></td>
            <td>
                <?= $formatter->asCurrency($order->total_price); ?>
            </td>
            <td><?= $order->uwagi ?></td>
            <td><?= $order->user['username'] ?></td>
            <td style="color: <?= $order->status == \common\models\Order::STATUS_NOT_REALIZED ? 'red' : 'green'; ?>">
                <?= Yii::t('app', 'ORDER_STATUS_' . $order->status); ?>
            </td>
            <td class="<?= $order->isRealized() ? \common\helpers\OrderView::getSettlementCssClass($order->paymentChange($order->total_price)) : ''; ?>">
                <?php if ($order->isRealized()): ?>
                    <span title="<?= \common\helpers\OrderView::getOrderChangeTitle($order); ?>">
                        <?= $formatter->asCurrency(abs($order->paymentChange($order->total_price))); ?>
                    </span>
                <?php endif ?>
            </td>
            <td>
                <?php if ($order->status == 0) {
                    echo $delete . $edit;
                } ?>

                <?php if ($order->canBeRealized()): ?>
                    <?= Html::a('Zrealizuj', ["restaurant?id=$takeRestaurantId"], ['class' => 'btn btn-custom']); ?>
                <?php endif; ?>

                <?php if ($order->isRealized()): ?>
                    <a title="Smakowało? Zamów raz jeszcze!" class=""
                       href="<?= \yii\helpers\Url::to(['/order/again', 'id' => $order->id]) ?>">
                        <span class="glyphicon glyphicon-cutlery"></span>
                    </a>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
    <?php foreach ($summary->getData() as $row): ?>
        <tr>
            <td colspan="3" class="text-right">
                <a href="<?= \yii\helpers\Url::to(['/site/restaurant', 'id' => $row->restaurant->id]); ?>">
                    <?= $row->restaurant->restaurantName ?> (<?= sprintf('%d / %d', $row->numOfRealizedOrders, $row->allOrders) ?>)
                </a>
            </td>
            <td class="text-left"><?= $formatter->asCurrency($row->price) ?></td>
            <td colspan="4" class="text-left"><?= $formatter->asCurrency($row->getCostWithDelivery()) ?></td>
            <td colspan="2" class="text-left <?= \common\helpers\OrderView::getSettlementCssClass($row->change); ?>">
                <span><?= $formatter->asCurrency($row->change) ?></span>
            </td>
        </tr>
    <?php endforeach; ?>
    </tfoot>
</table>
