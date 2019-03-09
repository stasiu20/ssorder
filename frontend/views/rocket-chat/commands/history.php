<?php
/** @var $user \common\models\User */
/** @var $orders \common\models\Order[] */
/** @var $date string */
/** @var $dateTo string */

if (null === $user): ?>
    Brak integracji z ssorder użyj komendy `info`.
<?php else: ?>
    <?php if (empty($orders)): ?>
        Brak zamówień w dniach <?= $date ?> - <?= $dateTo; ?>.
    <?php else: ?>
        Twoje zamówienia z dnia <?= $date ?> - <?= $dateTo; ?>:
        <?php foreach ($orders as $order): ?>
            <?= $this->render('/rocket-chat/partials/order', ['order' => $order]); ?>
        <?php endforeach; ?>
    <?php endif ?>
<?php endif ?>
