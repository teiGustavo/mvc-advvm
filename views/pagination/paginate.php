<?php
$this->layout("../_theme", ["title" => $title]);
?>

<?= $this->start('css'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<?= $this->stop(); ?>

<div class="container-sm rounded-3 bg-dark p-5 d-flex flex-column">

    <div class="d-flex justify-content-end">
        <div class="btn-group btn-group-md" role="group">
            <a role="button" class="btn btn-outline-light btn-page" aria-expanded="false" href="<?= $router->route('pagination.page', ['pagecode' => 1]); ?>">
                &laquo;
            </a>

            <a role="button" class="btn btn-outline-light btn-page" id="previousPageButton" aria-expanded="false" href="<?= $router->route('pagination.page', ['pagecode' => $previousPage]); ?>">
                &lt;
            </a>

            <button type="button" id="dropdownPages" class="btn btn-outline-light dropdown-toggle rounded-0" data-bs-toggle="dropdown" aria-expanded="false" style="transform: none;">
                Página: <?= $currentPage; ?>
            </button>
            <ul class="dropdown-menu overflow-y-scroll" style="max-height: 300px;">

                <div class="list-group list-group-flush text-center" role="group">

                    <?php foreach ($pages as $page) : ?>

                        <a href="<?= $router->route('pagination.page', ['pagecode' => $page]); ?>" class="list-group-item list-group-item-action"><?= $page; ?></a>

                    <?php endforeach; ?>

                </div>

            </ul>

            <a role="button" class="btn btn-outline-light btn-page" aria-expanded="false" href="<?= $router->route('pagination.page', ['pagecode' => $nextPage]); ?>">
                &gt;
            </a>

            <a role="button" class="btn btn-outline-light btn-page" aria-expanded="false" href="<?= $router->route('pagination.page', ['pagecode' => $lastPage]); ?>">
                &raquo;
            </a>
        </div>
    </div>

    <h1 class="fs-5 fw-bold">Lançamentos</h1>

    <div class="container-sm mt-5">

        <?php if ($reports) : ?>

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <td scope="col">Data</td>
                        <td scope="col">Lançamento</td>
                        <td scope="col">Tipo</td>
                        <td scope="col">Valor</td>
                        <td scope="col">Ações</td>
                    </tr>
                </thead>

                <tbody id="tbody">

                    <?php if (!empty($reports)) :
                        foreach ($reports as $report) :
                            $this->insert("../_fragments/tr-report", ["report" => $report]);
                        endforeach;
                    else :
                    ?>

                        <p>Erro ao listar os lançamentos!</p>

                    <?php endif; ?>

                </tbody>
            </table>

        <?php else : ?>

            <p>Não existem lançamentos cadastrados!</p>

        <?php endif; ?>

    </div>
</div>

<?php $this->insert("../_fragments/update-modal", ["formAction" => $router->route('report.update')]); ?>

<?= $this->start('js'); ?>
<script src="<?= url('/public/assets/js/pages/pagination/paginate.js'); ?>"></script>
<?= $this->end(); ?>