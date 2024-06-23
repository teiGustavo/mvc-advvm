<?php
$this->layout("../_bootstrap", ["title" => $title]);
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

            <a role="button" class="btn btn-outline-light btn-page" aria-expanded="false" href="<?= $router->route('pagination.page', ['pagecode' => $previousPage]); ?>">
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

            <tbody>
                <?php if ($reports) :
                    foreach ($reports as $report) :
                        $this->insert("../_fragments/tr-report", ["report" => $report]);
                    endforeach;
                else :
                ?>

                    <p>Não existem relatórios cadastrados!</p>

                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php $this->insert("../_fragments/update-modal", ["formAction" => $router->route('report.update')]); ?>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="deleteModalLabel">Atualizar Lançamento</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form>
                <div class="modal-body">
                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" id="date" name="date" placeholder="Dia do lançamento">
                        <label for="date">Dia</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="amount" name="amount" placeholder="Valor">
                        <label for="amount">Valor</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="report" name="report" placeholder="Descrição">
                        <label for="report">Lançamento</label>
                    </div>

                    <div class="form-floating">
                        <select class="form-select" id="type" name="type" aria-label="Tipo">
                            <option selected value="Automático">Automático</option>
                            <option value="Entrada">Entrada</option>
                            <option value="Saída">Saída</option>
                        </select>
                        <label for="type">Tipo</label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-success">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->start('js'); ?>
<script>
    const form = document.getElementById('updateForm');
    const dropdownPages = document.getElementById('dropdownPages');
    const updateForm = document.getElementById('updateForm');

    const updateButtons = document.querySelectorAll('[data-update]');
    const deleteButtons = document.querySelectorAll('[data-delete]');

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

                document.getElementById('btnCloseUpdateModal').dispatchEvent(new Event('click'));

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
                        deleteButton.parentNode.parentNode.remove();
                    }
                });
        });
    };

    document.querySelector(`.list-group-item-action[href='${location.href}']`).classList.add('active');
</script>
<?= $this->end(); ?>