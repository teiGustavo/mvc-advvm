<?php
$params = [
    "title" => $title
];

$this->layout("_theme", $params);
?>

<?php $this->start("sidebar"); ?>
<a class="nav-link active" href="<?= $router->route('error', ['errcode' => $error]); ?>">Erro <?=$error ?></a>
<a class="nav-link" href="<?= $router->route('advvm.home'); ?>">Voltar ao Início</a>
<?php $this->stop(); ?>

<div class="error">
    <h2 class="text-white">Ooooops, Algo deu errado!</h2>
    <h1 class="text-white"><?= "Erro " .  $error ?></h1>
</div>