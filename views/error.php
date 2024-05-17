<?php 
    $params = [
        "title" => $title
    ];

    $this->layout("_theme", $params); 
?>

<div class="error">
    <h2 class="text-white">Ooooops, Algo deu errado!</h2>
    <h1 class="text-white"><?= "Erro " .  $error ?></h1>
</div>

<?php $this->start("sidebar"); ?>
    <a href="<?= url("") ?>">Voltar ao Início</a>
<?php $this->stop(); ?>