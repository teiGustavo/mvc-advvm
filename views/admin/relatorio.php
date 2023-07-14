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
                $this->insert("fragments/report-two", ["report" => $report]);
            endforeach;
        else:
            ?>

            <h4>Não existem relatórios cadastrados!</h4>

        <?php endif; ?>
    </div>
</div>

<div class="relative z-10 hidden" id="modal-editar" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity">
    </div>

    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left" style="width: 430px;">
                            <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Editar Lançamento</h3>
                            <div class="mt-2">
                                <form>
                                    <div class="space-y-12">
                                        <div class="border-b border-gray-900/10 pb-12">
                                            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-4">
                                                <div class="sm:col-span-4">
                                                    <label for="data" class="block text-sm font-medium leading-6 text-gray-900">Data</label>
                                                    <div class="mt-2">
                                                        <input type="date" name="data" id="data" autocomplete="given-name" style="padding: 10px;" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                                    </div>
                                                </div>

                                                <div class="sm:col-span-4">
                                                    <label for="historico" class="block text-sm font-medium leading-6 text-gray-900">Histórico</label>
                                                    <div class="mt-2">
                                                        <input type="text" name="historico" id="historico" style="padding: 10px;" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                                    </div>
                                                </div>

                                                <div class="sm:col-span-4">
                                                    <label for="valor" class="block text-sm font-medium leading-6 text-gray-900">Valor</label>
                                                    <div class="relative mt-2 rounded-md shadow-sm">
                                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                                            <span class="text-gray-500 sm:text-sm">R$</span>
                                                        </div>
                                                        <input type="text" name="valor" id="valor" style="padding: 10px 0px 10px 35px;"
                                                               class="block w-full rounded-md border-0 py-1.5 pl-7 pr-20 text-gray-900
                                                                    ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2
                                                                    focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                                                    placeholder="0.00">
                                                    </div>
                                                </div>

                                                <div class="sm:col-span-4">
                                                    <label for="tipo" class="block text-sm font-medium leading-6 text-gray-900">Tipo</label>
                                                    <div class="mt-2">
                                                        <select id="tipo" name="tipo" autocomplete="country-name" style="padding: 10px;" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                                                            <option value="Entrada">Entrada</option>
                                                            <option value="Saída">Saída</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="button" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto"
                            data-edit>Editar</button>
                    <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
                            data-cancel>Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="relative z-10 hidden" id="modal-excluir" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity">
    </div>

    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Excluir Lançamento</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Você tem certeza que deseja excluir? Todos os dados serão permanentemente perdidos. Esta ação não poderá ser desfeita!</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="button" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto"
                        data-confirm>Excluir</button>
                    <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
                        data-cancel>Cancelar</button>
                </div>
            </div>
        </div>
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
        let pagination = $("#pagination");
        $(".reports").css("margin-top", "20px");

        pagination.css("border-radius", "10px");
        pagination.css("background", "#2f2841");
        pagination.removeClass("border-t");
        pagination.removeClass("border-gray-200");
        pagination.removeClass("border-gray-200");

        $("#pagination p, #pagination a").css("color", "white");

        $("#nav_a_limit").css("display", "inline-flex");

        nextPage();
    }

    updateReportCss();

    $("button").on("click", function () {
        let div_menu = ($(this).parent().parent().find("#div-menu"));

        if (div_menu.hasClass("hidden")) {
            div_menu.fadeIn(400);
            div_menu.removeClass("hidden");
        } else {
            div_menu.fadeOut(300);
            div_menu.addClass("hidden");
        }
    });

    $("body").on("click", "[data-update]", function (e) {
        e.preventDefault();

        $.ajax({
            url: data.action,
            data: {
                id: data.id
            },
            type: "POST",
            dataType: "JSON",
            success: function (callback) {
                // $("#cpf_cliente_edit").val(callback.customer.cpf);
                // $("#nome_cliente_edit").val(callback.customer.nome);
                // $("#email_cliente_edit").val(callback.customer.email);
                // $("#datanasc_cliente_edit").val(callback.customer.datanasc);
            }
        });

        let modal = $("#modal-editar");

        if (modal.hasClass("hidden")) {
            modal.fadeIn(400);
            modal.removeClass("hidden");
        } else {
            modal.fadeOut(300);
            modal.addClass("hidden");
        }

        $("body").on("click", "[data-cancel]", function (e) {
            modal.fadeOut(300);
            modal.addClass("hidden");
        })

        $("body").on("click", "[data-edit]", function (e) {
            $.post(data.action, data, "json")
                .done(function (callback) {
                    modal.fadeOut(300);
                    modal.addClass("hidden");
                    div.fadeOut();
                }).fail(function () {
                alert("Erro ao processar a requisição!");
            });
        })
    });

    $("body").on("click", "[data-delete]", function (e) {
        e.preventDefault();

        let data = $(this).data();
        let div = $(this).parent().parent().parent().parent().parent();

        let modal = $("#modal-excluir");

        if (modal.hasClass("hidden")) {
            modal.fadeIn(400);
            modal.removeClass("hidden");
        } else {
            modal.fadeOut(300);
            modal.addClass("hidden");
        }

        $("body").on("click", "[data-cancel]", function (e) {
            modal.fadeOut(300);
            modal.addClass("hidden");
        })

        $("body").on("click", "[data-confirm]", function (e) {
            $.post(data.action, data, "json")
                .done(function (callback) {
                    modal.fadeOut(300);
                    modal.addClass("hidden");
                    div.fadeOut();
                }).fail(function () {
                alert("Erro ao processar a requisição!");
            });
        })
    });
</script>
<?php $this->stop(); ?>