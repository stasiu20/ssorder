Zamówienie w restauracji _<?= $order->restaurants->restaurantName ?>_ na żarcie *<?= $order->getFoodName() ?>* za <?= Yii::$app->formatter->asCurrency($order->getPrice()) ?>.
UWAGI: <?= $order->uwagi ?>

