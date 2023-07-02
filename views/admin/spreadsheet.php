<?php
$this->layout("../_theme", ["title" => $title]);
?>

<?php $this->start("sidebar"); ?>
<a href="<?= $router->route("advvm.home"); ?>">Home</a>
<a href="<?= $router->route("admin.excel"); ?>">Voltar</a>
<?php $this->stop(); ?>

<form action="<?= $router->route("admin.excel.download"); ?>" method="POST">
    <div class="selectYear">
        <label for="selectMonth">Selecione o mês:</label>
        <select name="selectMonth" id="">
            <?php foreach ($reports as $report):
                ?>
                <option value="<?= $report->date_report; ?>"><?= $report->date_report; ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit" class="btns">DOWNLOAD</button>
    </div>
</form>