<?php
$this->layout("../_bootstrap", ["title" => $title]);
?>

<div class="p-5 bg-one rounded-3" style="min-width: 500px;">
    <h1 class="fs-6 fw-bold text-light">Cadastro de Relatório</h1>

    <div class="mt-5">
        <form action="<?= $router->route("create.reportRegistration"); ?>" method="POST">
            <div class="form-floating mb-3">
                <input type="month" class="form-control text-capitalize" id="date" name="date" placeholder="Mês dos lançamentos">
                <label for="date">Mês dos lançamentos</label>
            </div>

            <button type="submit" class="btn btn-outline-light mt-3" name="btnSubmit" value="continuar">Começar</button>
        </form>
    </div>
</div>