<?php
$this->layout("../_bootstrap", ["title" => $title]);
?>

<div class="container-sm bg-one rounded-3 p-5 bg-dark" style="max-width: 800px;">
    <h1 class="fs-5 fw-bold">Baixar Planilha</h1>

    <?php if (!empty($years)) : ?>

        <div class="mt-5">
            <form action="<?= $router->route('spreadsheet.download');?>" id="form">
                <div class="form-floating mb-3">
                    <select class="form-select" id="selectYear" name="year" aria-label="Selecione o ano do relatório" data-action="<?= $router->route('spreadsheet.findMonths'); ?>">
                        <option value="" selected>Selecione o ano</option>

                        <?php foreach ($years as $year) : ?>

                            <option value="<?= $year; ?>"><?= $year; ?></option>

                        <?php endforeach; ?>

                    </select>
                    <label for="selectYear">Selecione o ano</label>
                </div>

                <div class="form-floating mb-3">
                    <select class="form-select" id="selectMonth" name="month" aria-label="Selecione o mês do relatório" style="cursor: not-allowed;" disabled>
                        <option selected>Selecione o mês</option>
                    </select>
                    <label for="selectMonth">Selecione o mês</label>
                </div>

                <button type="submit" class="btn btn-success mb-0" style="cursor: not-allowed;" id="button" disabled>Baixar</button>
            </form>
        </div>

    <?php else : ?>

        <p class="mb-0 mt-5">Não há relatórios cadastrados!</p>

    <?php endif; ?>
</div>

<?php $this->start("js"); ?>
<script>
    const form = document.getElementById('form');
    const selectYear = document.getElementById('selectYear');
    const selectMonth = document.getElementById('selectMonth');
    const button = document.getElementById('button');

    selectYear.addEventListener('change', () => {
        const formData = new FormData(form);

        fetch(selectYear.getAttribute('data-action'), {
                method: 'POST',
                body: formData
            })
            .then((response) => response.json())
            .then((data) => {
                const months = data.months;

                if (months) {
                    selectMonth.removeAttribute('disabled');
                    selectMonth.innerHTML = '';
                    selectMonth.style.cursor = 'pointer';

                    months.forEach(month => {
                        const option = new Option(month, month);

                        selectMonth.add(option);
                    });

                    button.removeAttribute('disabled');
                    button.style.cursor = 'pointer';
                } else {
                    button.setAttribute('disabled', 'true');
                    button.style.cursor = 'not-allowed';

                    selectMonth.setAttribute('disabled', 'true');
                    selectMonth.innerHTML = '<option selected>Selecione o mês</option>';
                    selectMonth.style.cursor = 'not-allowed';
                }
            });
    });

    form.addEventListener('submit', (e) => {
        e.preventDefault();

        const formData = new FormData(form);

        fetch(form.getAttribute('action'), {
                method: 'POST',
                body: formData
            })
            .then((response) => response.json())
            .then((data) => {
                window.location = data.download_url;
            });
    });
</script>
<?php $this->stop(); ?>