<?php
$this->layout("../_theme", ["title" => $title]);
?>

<?php if ($currentMonth != 0):
    $this->start("sidebar");
    ?>

    <a href="<?= url("/admin/excel"); ?>">Voltar</a>

    <?php
    $this->stop();
    ?>

    <a href="<?= "/../../" . $caminho; ?>" download="<?= $file; ?>"><button id="download">Baixar Planilha<button></a>

<?php endif; ?>



<?php $this->start("js"); ?>
<script>
</script>
<?php $this->stop(); ?>