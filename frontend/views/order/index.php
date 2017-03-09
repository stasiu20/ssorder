<?php

use yii\helpers\Html;

$this->title = 'Zamówienia';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1>Zamówienia z Dnia: <?= date('d-m-Y') ?> </h1>
<?php
$userName = Yii::$app->user->identity->username;

$formatter = \Yii::$app->formatter;
?>
<p>sortuj według: <?=$sort->link('restaurant');?></p>
<table class="table table-striped">
    <thead><th>Nazwa Żarcia</th><th>Nazwa Restauracji</th><th>Cena</th><th>Uwagi</th><th>Kto Zamawia</th><th>Status</th><th>Usuń/edytuj/zrealizuj</th></thead>
<tbody>
<?php
foreach ($model as $order):
    $delete = ($userName === $order->user['username'] ? Html::a('usuń', ["delete"], ['class' => 'btn btn-danger', 'style' =>'margin-right:10px',
                            'data' => [
                                'confirm' => 'Jesteś pewien, że chcesz odmówić to zamówienie?',
                                'method' => 'post',
                                'params'=>['id'=>$order->id]
                            
                        ],]) : '');
    $edit = ($userName == $order->user['username'] ? Html::a('edytuj', ["edit"], ['class' => 'btn btn-success', 'style' =>'margin-right:10px',
                            'data' => [
                                'method' => 'post',
                                'params'=>['name'=>Yii::$app->user->identity->username, 'id'=>$order->id],
                                
                                ]]) : '');
    $takeRestaurantId = $order->menu->restaurants[0]['id'];
    $takeOrder = Html::a('Zrealizuj', ["restaurant?id=$takeRestaurantId"], ['class' => 'btn btn-primary']);
    ?>

        <tr>
            <td><a href="/site/view?id=<?=$order->menu->id?>&order=true"><?= $order->menu->foodName ?></a></td>
            <td><a href="/site/restaurant?id=<?= $order->menu->restaurants[0]['id'] ?>"><?= $order->menu->restaurants[0]['restaurantName'] ?></a></td>
            <td><?=$formatter->asCurrency($order->menu->foodPrice) ?></td>
            <td><?= $order->uwagi ?></td>
            <td><?= $order->user['username'] ?></td>
            <td style="color: <?php if($order->status == 0) { echo 'red';}else{ echo 'green';}?>"><?php if($order->status == 0){echo "do realizacji";}else{echo "zrealizowane";}?></td>
            <td><?php   if($order->status == 0){echo  $delete . $edit . $takeOrder;} ?></td>
        </tr>
<?php endforeach; ?>
</tbody>
</table>
