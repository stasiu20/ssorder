<?php if (null === $user): ?>
    Brak integracji z ssorder użyj komendy `info`.
<?php else: ?>
    <?php if (empty($orders)): ?>
        Brak zamówień w dniu dzisiejszym.
    <?php else: ?>
        Twoje dzisiejsze zamówienia:
        <?php foreach ($orders as $order): ?>
            <?= $this->render('/rocket-chat/partials/order', ['order' => $order]); ?>
        <?php endforeach; ?>
    <?php endif ?>
<?php endif ?>
