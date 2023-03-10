<?php
    $this->layout("../_theme", ["title" => $title]);
?>

<div class="pagination" id="divPagination">
    <div id="menuPagination">
    <div class="flex items-center justify-between border-t border-gray-200 bg-inline-flex px-4 py-3 sm:px-6" id="pagination">
        <div class="flex flex-1 justify-between sm:hidden">
            <a href="#"
                class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</a>
            <a href="#"
                class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Next</a>
        </div>
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    Exibindo
                    <span class="font-medium"><?= $first_report+1 ?></span>
                    a
                    <span class="font-medium"><?= $last_report < $total_reports ? $last_report : $total_reports; ?></span>
                    de
                    <span class="font-medium"><?= $total_reports; ?></span>
                    resultados
                </p>
            </div>
            <div>
                <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination" id="paginacao">
                    <a href="<?= $router->route("admin.reports.page", ["pagecode" => $previous_page]); ?>"
                        class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                        <span class="sr-only">Previous</span>
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="<?= $router->route("admin.reports.page", ["pagecode" => 1]); ?>" aria-current="page" id="nav_a"
                        class="relative z-10 inline-flex items-center ring-1 ring-inset ring-gray-300 px-4 py-2 text-sm font-semibold text-white focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">1</a>
                    <a href="<?= $router->route("admin.reports.page", ["pagecode" => $next_page]); ?>" id="nav_a<?= $current_page; ?>"
                        class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"><?= $current_page; ?></a>
                    <span
                        class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 focus:outline-offset-0">...</span>
                    <a href="<?= $router->route("admin.reports.page", ["pagecode" => $total_pages]); ?>" id="nav_a_limit"
                        class="relative hidden items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 md:inline-flex"><?= $total_pages; ?></a>
                    <a href="<?= $router->route("admin.reports.page", ["pagecode" => $next_page]); ?>" id="nav_a"
                        class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                        <span class="sr-only">Next</span>
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                </nav>
            </div>
        </div>
    </div>
    </div>

    <div id="reports">
        <?php if ($reports):
            foreach ($reports as $report):
                ?>

                <article class="users_user">
                    <h1>
                        <?= "ID: " . $report->cod_lancamento . "<br>Data: " . $report->data_report . "<br>Histórico: " . $report->historico . "<br>Tipo: " . $report->tipo . "<br>Valor: " . $report->valor ?>
                    </h1>
                </article>

                <?php
            endforeach;
        else:
            ?>

            <h4>Não existem relatórios cadastrados!</h4>

        <?php endif; ?>
    </div>

</div>

<?php $this->start("js"); ?>
<script>
    function nextPage() {
        if (($("#nav_a<?= $current_page; ?>")).hasClass("ring-1")) {
            $("#nav_a<?= $current_page; ?>").removeClass("ring-1");
            $("#nav_a<?= $current_page; ?>").addClass("bg-indigo-600");
        }

        if ("<?= $current_page; ?>" == 1) {
            $("#nav_a<?= $current_page; ?>").addClass("ring-1");
            $("#nav_a<?= $current_page; ?>").removeClass("bg-indigo-600");

            $("#nav_a").removeClass("ring-1");
            $("#nav_a").addClass("bg-indigo-600");

            $("#nav_a<?= $current_page; ?>").text("<?= $next_page; ?>");
            $("#nav_a<?= $current_page; ?>").attr("href", "<?= $router->route("admin.reports.page", ["pagecode" => $next_page]); ?>");
        }

        if ("<?= $current_page; ?>" == "<?= $total_pages; ?>") {
            $("#nav_a<?= $current_page; ?>").addClass("ring-1");
            $("#nav_a<?= $current_page; ?>").removeClass("bg-indigo-600");

            $("#nav_a_limit").removeClass("ring-1");
            $("#nav_a_limit").addClass("bg-indigo-600");

            $("#nav_a<?= $current_page; ?>").text("<?= $previous_page; ?>");
            $("#nav_a<?= $current_page; ?>").attr("href", "<?= $router->route("admin.reports.page", ["pagecode" => $previous_page]); ?>");
        }
    }

    function updateReportCss() {
        $(".reports").css("margin-top", "20px");

        $("#pagination").css("border-radius", "10px");
        $("#pagination").css("background", "#2f2841");
        $("#pagination").removeClass("border-t");
        $("#pagination").removeClass("border-gray-200");
        $("#pagination").removeClass("border-gray-200");

        $("#pagination p, #pagination a").css("color", "white");

        $("#nav_a_limit").css("display", "inline-flex");

        nextPage();
    }

    updateReportCss();
</script>
<?php $this->stop(); ?>