<?php
$this->layout("../_bootstrap", ["title" => $title]);
?>

<?php $this->start("sidebar"); ?>
<a class="nav-link" href="<?= $router->route('auth.login'); ?>">Entrar</a>
<a class="nav-link" href="<?= $router->route('auth.register'); ?>">Criar Conta</a>

<?php if (NEEDS_AUTH !== 'true') : ?>

  <a class="nav-link" href="<?= $router->route('advvm.home'); ?>">Entrar Anonimamente</a>

<?php endif;
$this->stop(); ?>

<div class="container-sm bg-dark rounded-3 p-5" style="max-width: 700px;">
  <h1 class="fs-5">Que bom ver você!</h1>
  <h2 class="fs-6">Por favor, crie sua conta para continuar.</h2>

  <div class="container-sm mt-5" style="max-width: 500px;">
    <form action="<?= $router->route("auth.createUser"); ?>" method="POST">
      <div class="form-floating mb-3">
        <input type="email" class="form-control" id="email" name="email" placeholder="Insira seu email">
        <label for="email">Email</label>
      </div>

      <div class="form-floating mb-3">
        <input type="password" class="form-control" id="password" name="password" placeholder="Insira sua senha">
        <label for="password">Senha</label>
      </div>

      <div class="form-floating mb-3">
        <input type="password" class="form-control" id="repeat-password" name="repeatPassword" placeholder="Insira sua senha novamente" disabled>
        <label for="repeat-password">Repita sua senha</label>
      </div>

      <button type="submit" class="btn btn-outline-light">Criar Conta</button>
    </form>
  </div>
</div>