Wiadomość od <?= $request->user_name ?>, id rocketchat `<?= $request->user_id ?>`
<?php if (null === $user): ?>
    Nie masz integracji między ssorder a rocketchat :/
<?php else: ?>
    Twój login w ssorder to `<?= $user->username ?>`
<?php endif; ?>
