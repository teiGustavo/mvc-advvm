<!DOCTYPE html>
<html lang="pr-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?= $this->section("css"); ?>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?= url("/views/assets/css/style.css") ?>">

    <title>
        <?= $title; ?>
    </title>
</head>

<body>
    <?php initializeSessions(); ?>

    <nav class="main_nav">
        <?php
        if ($this->section("sidebar")):
            echo $this->section("sidebar");
        else :
            ?>

            <a href="<?= $router->route("advvm.home"); ?>">Home</a>
            <a href="<?= $router->route("admin.reports"); ?>">Relatórios</a>
            <a href="<?= $router->route("admin.excel"); ?>">Excel</a>
            <a href="<?= url("/crud") ?>">CRUD</a>
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

    <script src="<?= url("/views/assets/js/jquery.js") ?>"></script>
    <?= $this->section("js"); ?>

</body>

</html>