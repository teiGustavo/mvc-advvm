<?php
$params = [
    "title" => $title
];

$this->layout("_bootstrap", $params);
?>

<div class="error">
    <h2 class="text-white">Ooooops, Algo deu errado!</h2>
    <h1 class="text-white"><?= "Erro " .  $error ?></h1>
</div>

<?php $this->start("sidebar"); ?>
<a class="nav-link" href="<?= $router->route('advvm.home'); ?>">Voltar ao Início</a>
<?php $this->stop(); ?>