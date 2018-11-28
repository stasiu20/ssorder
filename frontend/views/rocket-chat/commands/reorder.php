<?php
/** @var $newOrder \common\models\Order */
?>

Złożono nowe zamówienie `#<?= $newOrder->id ?>` w restauracji _<?= $newOrder->restaurants->restaurantName ?>_ na żarcie *<?= $newOrder->getFoodName() ?>* za <?= Yii::$app->formatter->asCurrency($newOrder->getPrice()) ?>.
<?php if (!empty($newOrder->uwagi)): ?>
    UWAGI: <?= $newOrder->uwagi ?>
<?php endif; ?>
