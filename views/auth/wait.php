<?php
$this->layout("../_theme", ["title" => $title]);
?>

<?php $this->start("sidebar"); ?>
<a class="nav-link" href="<?= $router->route('auth.wait'); ?>">Checkout</a>
<a class="nav-link" href="<?= $router->route('auth.login'); ?>">Entrar</a>

<?php if (NEEDS_AUTH !== 'true') : ?>

  <a class="nav-link" href="<?= $router->route('advvm.home'); ?>">Entrar Anonimamente</a>

<?php endif;
$this->stop(); ?>

<div class="container-sm bg-dark rounded-3 p-5" style="max-width: 700px;">
  <h1 class="fs-5">Por favor, aguarde que um de nossos administradores libere seu acesso.</h1>
  <h2 class="fs-6 mt-3 mb-0">Em caso de dúvida, entre em contato com o suporte.</h2>
</div>