<?php
$this->layout("../_theme", ["title" => $title]);
?>

<?php if (isset($years) && !empty($years)) : ?>

<form action="<?= $router->route("admin.excel.spreadsheet"); ?>" method="POST">
    <div class="selectYear">
        <label for="selectYear">Selecione o ano:</label>
        <select name="selectYear" id="">
            <?php foreach ($years as $year) :
            ?>
                <option value="<?= $year; ?>"><?= $year; ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit" class="btns">SELECIONAR</button>
    </div>
</form>

<?php else : ?>

<h1 class="text-white">Não há lançamentos para gerar um relatório!</h1>

<?php endif; ?>