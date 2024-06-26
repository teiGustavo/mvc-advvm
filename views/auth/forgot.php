<?php
$this->layout("../_theme", ["title" => $title]);
?>

<?php $this->start("sidebar"); ?>
<a class="nav-link" href="<?= $router->route('auth.forgot'); ?>">Recuperação</a>
<a class="nav-link" href="<?= $router->route('auth.login'); ?>" id="return">Voltar</a>
<?php $this->stop(); ?>

<div class="container-sm bg-dark rounded-3 p-5" style="max-width: 700px;">
  <h1 class="fs-5">Não entre em pânico!</h1>
  <h2 class="fs-6">Insira seu email para recuperar sua senha.</h2>

  <div class="container-sm mt-5" style="max-width: 500px;">
    <form action="<?= $router->route("user.findByEmail"); ?>" method="POST" id="form">
      <div class="form-floating mb-3">
        <input type="email" class="form-control" id="email" name="email" placeholder="Insira seu email">
        <label for="email">Email</label>
      </div>

      <button type="submit" class="btn btn-outline-light">Procurar Conta</button>
    </form>
  </div>
</div>

<?php $this->insert("../_fragments/redefine-password", ["formAction" => $router->route('user.updatePassword')]); ?>

<?php $this->start("js"); ?>
<script src="<?= url('/public/assets/js/pages/auth/forgot.js'); ?>"></script>
<?php $this->stop(); ?>