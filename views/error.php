<?php 
    $params = [
        "title" => $title
    ];

    $this->layout("_theme", $params); 
?>

<div class="error">
    <h2>Ooooops, Algo deu errado!</h2>
    <h1><?= "Erro " .  $error ?></h1>
</div>

<?php $this->start("sidebar"); ?>
    <a href="<?= url("") ?>">Voltar ao Início</a>
<?php $this->stop(); ?>