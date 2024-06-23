<?php
$this->layout("_bootstrap", ["title" => $title]);
?>

<div>
    <?php if (NEEDS_AUTH === 'true') : ?>

        <h1 class="fs-5">Olá usuário(a),</h1>
        <h2 class="fs-6">Seja bem vindo(a) ao sistema!</h2>

    <?php else : ?>

        <h1 class="fs-5">Seja bem vindo(a) ao sistema!</h1>

    <?php endif; ?>
</div>