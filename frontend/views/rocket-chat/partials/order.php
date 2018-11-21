Zamówienie `#<?= $order->id ?>` w restauracji _<?= $order->restaurants->restaurantName ?>_ na żarcie *<?= $order->getFoodName() ?>* za <?= Yii::$app->formatter->asCurrency($order->getPrice()) ?>.
<?php if (!empty($order->uwagi)): ?>
    UWAGI: <?= $order->uwagi ?>
<?php endif; ?>

