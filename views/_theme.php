<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/x-icon" href="<?= url("/public/favicon.ico"); ?>">

    <?= $this->section("css"); ?>
    <link rel="stylesheet" href="<?= url("/public/assets/css/style.css") ?>">
    <link rel="stylesheet" href="<?= url('/node_modules/bootstrap/dist/css/bootstrap.min.css'); ?>">

    <title><?= $title; ?></title>
</head>

<body data-bs-theme="dark" class="bg-secondary-subtle" id="body">
    <nav class="navbar navbar-expand-lg p-3 shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= $router->route('advvm.home'); ?>">ADVVM</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-center" id="navbarNavAltMarkup">
                <div class="navbar-nav">

                    <?php if ($this->section("sidebar")) :
                        echo $this->section("sidebar");
                    else : ?>

                        <a class="nav-link" href="<?= $router->route('advvm.home'); ?>">Início</a>
                        <a class="nav-link" href="<?= $router->route('create.selectMonth'); ?>">Cadastrar</a>
                        <a class="nav-link" href="<?= $router->route('pagination.page', ['pagecode' => 1]); ?>">Lançamentos</a>
                        <a class="nav-link" href="<?= $router->route('spreadsheet.index'); ?>">Gerar Relatório</a>

                        <?php if (NEEDS_AUTH === 'true') : ?>

                            <a class="nav-link" href="<?= $router->route('admin'); ?>">Administração</a>

                            <a class="nav-link" href="<?= $router->route('auth.logout'); ?>">Sair</a>

                        <?php endif; ?>

                    <?php endif; ?>

                </div>
            </div>
        </div>
    </nav>

    <main class="main_content">
        <?= $this->section("content"); ?>
    </main>

    <footer class="main_footer">
        &copy; <?= SITE; ?> - Todos os Direitos Reservados
    </footer>

    <script src="<?= url('/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?= url('/public/assets/js/pages/_theme.js'); ?>"></script>
    <?= $this->section("js"); ?>
</body>

</html>