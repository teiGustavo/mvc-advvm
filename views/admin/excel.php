<?php
$this->layout("../_theme", ["title" => $title]);

if ($currentMonth != 0) {
    $router->redirect("/files/" . $file);
}
?>

<form action="">
    <div>
        <label for="selectYear">Selecione o ano</label>
        <select name="selectYear" id="">
            <?php foreach ($reports as $report):
                ?>
                <option value="<?= $report->date_report; ?>"><?= $report->date_report; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</form>