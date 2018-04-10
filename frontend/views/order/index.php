<?php

use yii\helpers\Html;
/** @var \DateTime $date */
/** @var \DateTime $yesterday */
/** @var \DateTime $tomorrow */
/** @var \DateTime $today */
/** @var \DateTime $minDate */
/** @var \DateTime $sevenDaysAgo */
/** @var \DateTime $sevenDaysNext */
/** @var \frontend\models\Order $order */
/** @var \frontend\models\OrderSummaryRow[] $summary */

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
                <a href="<?= \yii\helpers\Url::to(['/order', 'date' => $tomorrow->format('Y-m-d')]) ?>"><span class="glyphicon glyphicon-chevron-right"></span></a>
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
<p>sortuj według: <?=$sort->link('restaurant');?></p>
<table class="table table-striped">
    <thead><th>Nazwa Żarcia</th><th>Nazwa Restauracji</th><th>Cena</th><th>Uwagi</th><th>Kto Zamawia</th><th>Status</th><th>Akcje</th></thead>
<tbody>
<?php
foreach ($model as $order):
    $delete = ($userName === $order->user['username'] ? Html::a('usuń', ["delete"], ['class' => 'btn btn-custom', 'style' =>'margin-right:10px',
                            'data' => [
                                'confirm' => 'Jesteś pewien, że chcesz odmówić to zamówienie?',
                                'method' => 'post',
                                'params'=>['id'=>$order->id]
                            
                        ],]) : '');
    $edit = ($userName == $order->user['username'] ? Html::a('edytuj', ["edit"], ['class' => 'btn btn-custom', 'style' =>'margin-right:10px',
                            'data' => [
                                'method' => 'post',
                                'params'=>['name'=>Yii::$app->user->identity->username, 'id'=>$order->id],
                                
                                ]]) : '');
    $takeRestaurantId = $order->menu->restaurants[0]['id'];
    $takeOrder = Html::a('Zrealizuj', ["restaurant?id=$takeRestaurantId"], ['class' => 'btn btn-custom']);
    ?>

        <tr>
            <td><a href="/site/view?id=<?=$order->menu->id?>&order=true"><?= $order->menu->foodName ?></a></td>
            <td><a href="/site/restaurant?id=<?= $order->menu->restaurants[0]['id'] ?>"><?= $order->menu->restaurants[0]['restaurantName'] ?></a></td>
            <td><?=$formatter->asCurrency($order->menu->foodPrice) ?></td>
            <td><?= $order->uwagi ?></td>
            <td><?= $order->user['username'] ?></td>
            <td style="color: <?php if($order->status == 0) { echo 'red';}else{ echo 'green';}?>"><?php if($order->status == 0){echo "do realizacji";}else{echo "zrealizowane";}?></td>
            <td>
                <?php if($order->status == 0){echo  $delete . $edit . $takeOrder;} ?>
                <?php if ($order->isRealized()): ?>
                    <a title="Smakowało? Zamów raz jeszcze!" class="" href="<?= \yii\helpers\Url::to(['/order/again', 'id' => $order->id]) ?>">
                        <span class="glyphicon glyphicon-cutlery"></span>
                    </a>
                <?php endif; ?>
            </td>
        </tr>
<?php endforeach; ?>
</tbody>
<tfoot>
    <?php foreach ($summary as $row): ?>
        <tr>
            <td colspan="2" class="text-right">
                <a href="<?= \yii\helpers\Url::to(['/site/restaurant', 'id' => $row->restaurant->id]); ?>">
                    <?= $row->restaurant->restaurantName ?>
                </a>
            </td>
            <td colspan="5" class="text-left"><?= $formatter->asCurrency($row->price) ?></td>
        </tr>
    <?php endforeach; ?>
</tfoot>
</table>
