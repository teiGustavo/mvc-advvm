<?php
$this->layout("../../_theme", ["title" => $title]);
?>

<div class="div-list">
    <ul role="list" class="divide-y divide-gray-100">
        <?php foreach ($reports as $report):
            $this->insert("../fragments/report", ["report" => $report]);
        endforeach; ?>
    </ul>
</div>

<?php $this->start("js"); ?>
<script>
    $("#menu-button").on("click", function () {
        let div_menu = $("#div-menu");

        if (div_menu.hasClass("hidden")) {
            div_menu.fadeIn(400);
            div_menu.removeClass("hidden");
        } else {
            div_menu.fadeOut(300);
            div_menu.addClass("hidden");
        }
    });
</script>
<?php $this->stop(); ?>

