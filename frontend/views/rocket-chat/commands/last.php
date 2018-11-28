<?php
/** @var $user \common\models\User */
/** @var $order \common\models\Order */

if (null === $user): ?>
    Brak integracji z ssorder użyj komendy `info`.
<?php else:
    if ($order): ?>
        Twoje ostatnie zamówienie z dnia <?= $order->data ?>
        <?= $this->render('/rocket-chat/partials/order', ['order' => $order]); ?>
    <?php else: ?>
        Jeszcze niczego nie zamówiłeś!
    <?php endif; ?>
<?php endif; ?>
