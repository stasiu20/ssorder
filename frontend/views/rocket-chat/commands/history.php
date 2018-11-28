<?php
/** @var $user \common\models\User */
/** @var $orders \common\models\Order[] */
/** @var $date string */

if (null === $user): ?>
    Brak integracji z ssorder użyj komendy `info`.
<?php else: ?>
    <?php if (empty($orders)): ?>
        Brak zamówień w dniu <?= $date ?>.
    <?php else: ?>
        Twoje zamówienia z dnia <?= $date ?>:
        <?php foreach ($orders as $order): ?>
            <?= $this->render('/rocket-chat/partials/order', ['order' => $order]); ?>
        <?php endforeach; ?>
    <?php endif ?>
<?php endif ?>
