<?php
$this->layout("../_theme", ["title" => $title]);
?>

<form action="<?= $router->route("admin.excel.spreadsheet");?>" method="POST">
    <div class="selectYear">
        <label for="selectYear">Selecione o ano:</label>
        <select name="selectYear" id="">
            <?php foreach ($reports as $report):
                ?>
                <option value="<?= $report->date_report; ?>"><?= $report->date_report; ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit" class="btns">SELECIONAR</button>
    </div>
</form>