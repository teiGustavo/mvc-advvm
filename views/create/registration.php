<?php
$this->layout("../_theme", ["title" => $title]);
?>

<?php $this->start("sidebar"); ?>

<a class="nav-link" href="<?= $router->route('create.reportRegistration'); ?>">Cadastro</a>
<a class="nav-link" href="<?= $router->route('create.selectMonth'); ?>">Sair</a>

<?php $this->stop(); ?>

<div class="container-sm bg-dark p-5 rounded-3" style="max-width: 800px;">
    <h1 class="fs-5 fw-bold">Cadastro de Relatório</h1>

    <div class="mt-5">
        <form action="<?= $router->route('report.store'); ?>" id="form">
            <div class="row">
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" id="date" name="date" placeholder="Dia do lançamento" min="<?= $minDate; ?>" max="<?= $maxDate; ?>">
                        <label for="date">Dia</label>
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="amount" name="amount" placeholder="Valor">
                        <label for="amount">Valor</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="report" name="report" placeholder="Descrição">
                        <label for="report">Lançamento</label>
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating">
                        <select class="form-select" id="type" name="type" aria-label="Tipo">
                            <option selected value="Automático">Automático</option>
                            <option value="Entrada">Entrada</option>
                            <option value="Saída">Saída</option>
                        </select>
                        <label for="type">Tipo</label>
                    </div>
                </div>
            </div>

            <div class="mt-4 mb-0">
                <a class="btn btn-danger" href="<?= $router->route('create.selectMonth'); ?>" role="button">Sair</a>

                <button type="submit" class="btn btn-success mb-0">Cadastrar</button>
            </div>
        </form>
    </div>
</div>

<?php $this->start("js"); ?>
<script>
    let form = document.getElementById('form');

    form.addEventListener('submit', (e) => {
        e.preventDefault();

        const formData = new FormData(form);

        fetch(form.getAttribute('action'), {
                method: 'POST',
                body: formData
            })
            .then((response) => response.json())
            .then((data) => {
                console.log(data);

                document.getElementById('date').value = ''
                document.getElementById('report').value = ''
                document.getElementById('amount').value = ''
                document.getElementById('type').value = 'Automático'
            });
    });
</script>
<?php $this->stop(); ?>