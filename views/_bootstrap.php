<!DOCTYPE html>
<html lang="pr-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/x-icon" href="<?= url("/public/favicon.ico"); ?>">

    <?= $this->section("css"); ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= url("/public/assets/css/style.css") ?>">

    <title>
        <?= $title; ?>
    </title>
</head>

<body>
    <?php initializeSessions(); ?>

    <nav class="main_nav">
        <?php
        if ($this->section("sidebar")) :
            echo $this->section("sidebar");
        else :
        ?>

            <a href="<?= $router->route("advvm.home"); ?>">Home</a>
            <a href="<?= $router->route("create.selectMonth"); ?>">Cadastrar</a>
            <a href="<?= $router->route("records.list"); ?>">Lançamentos</a>
            <a href="<?= $router->route("spreadsheet.selectYear"); ?>">Gerar Relatório</a>
            <a href="<?= $router->route("auth.logout"); ?>">Sair</a>

        <?php endif; ?>
    </nav>

    <main class="main_content">
        <?= $this->section("content"); ?>
    </main>

    <footer class="main_footer">
        ©
        <?= SITE; ?> - Todos os Direitos Reservados
    </footer>

    <script src="<?= url("/public/assets/js/jquery.js") ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <?= $this->section("js"); ?>

</body>

</html>