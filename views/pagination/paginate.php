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
<script>
    const form = document.getElementById('updateForm');
    const dropdownPages = document.getElementById('dropdownPages');
    const updateForm = document.getElementById('updateForm');

    const updateButtons = document.querySelectorAll('[data-update]');
    const deleteButtons = document.querySelectorAll('[data-delete]');

    const tbody = document.getElementById('tbody');

    let tr;

    dropdownPages.addEventListener('click', () => {
        document.querySelector(`.active[href='${location.href}']`).focus();
    });

    for (const updateButton of updateButtons) {
        updateButton.addEventListener('click', (e) => {
            e.preventDefault();

            const url = updateButton.getAttribute('data-target');
            const formData = new FormData();

            formData.append('id', updateButton.getAttribute('data-update'));

            fetch(url, {
                    method: 'POST',
                    body: formData
                })
                .then((response) => response.json())
                .then((data) => {
                    const report = data.report;

                    if (report) {
                        document.getElementById('id').value = report.id;
                        document.getElementById('date').value = report.date;
                        document.getElementById('report').value = report.report;
                        document.getElementById('type').value = report.type;
                        document.getElementById('amount').value = report.amount;
                    }
                });

            tr = updateButton.parentElement.parentElement;
        });
    };

    updateForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const url = updateForm.getAttribute('action');
        const formData = new FormData(updateForm);

        fetch(url, {
                method: 'POST',
                body: formData
            })
            .then((response) => response.json())
            .then((data) => {
                const report = data.report;
                const td = tr.getElementsByTagName('td');

                document.getElementById('btnCloseUpdateModal').click();

                td[0].innerHTML = report.date;
                td[1].innerHTML = report.report;
                td[2].innerHTML = report.type;
                td[3].innerHTML = report.amount;
            });
    });

    for (const deleteButton of deleteButtons) {
        deleteButton.addEventListener('click', (e) => {
            e.preventDefault();

            const url = deleteButton.getAttribute('data-target');
            const formData = new FormData();

            formData.append('id', deleteButton.getAttribute('data-delete'));

            fetch(url, {
                    method: 'POST',
                    body: formData
                })
                .then((response) => response.json())
                .then((data) => {
                    const isRemoved = data.remove;

                    if (isRemoved === true) {
                        function fadeOut(element) {
                            element.style.opacity = 1;

                            let opacity = 1;
                            const interval = setInterval(() => {
                                opacity -= 0.25;
                                element.style.opacity = opacity;

                                if (opacity <= 0) {
                                    clearInterval(interval);
                                    element.remove();

                                    if (tbody.childElementCount <= 0) {
                                        document.getElementById('previousPageButton').click();
                                    }
                                }
                            }, 50);
                        }

                        fadeOut(deleteButton.parentNode.parentNode);
                    }
                });
        });
    };

    document.querySelector(`.list-group-item-action[href='${location.href}']`).classList.add('active');
</script>
<?= $this->end(); ?>