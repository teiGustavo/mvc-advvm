<article class="users_user">
    <div>
        <h1>
            <p id="p_id">
                ID: <?= $report->getId(); ?>
            </p>

            <p id="p_date">
                Data: <?= $report->getFormattedDate(); ?>
            </p>

            <p id="p_report">
                Histórico: <?= $report->getReportWithTruncatedWidth(); ?>
            </p>

            <p id="p_type">
                Tipo: <?= $report->getType(); ?>
            </p>

            <p id="p_amount">
                Valor: <?= $report->getAmountInBRLFormat(); ?>
            </p>
        </h1>
    </div>

    <div class="hidden sm:flex sm:flex-col sm:items-end" style="align-self: center; flex: auto;">
        <div class="relative inline-block text-left">
            <div>
                <button type="button" class="inline-flex w-full justify-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                        id="menu-button" aria-expanded="true" aria-haspopup="true">
                    Ações
                    <svg class="-mr-1 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>

            <div class="absolute right-0 z-10 mt-2 w-56 origin-top-right divide-y divide-gray-200 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none hidden"
                 id="div-menu" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1" >
                <div class="py-1" role="none">
                    <button type="button" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1"
                            id="menu-item-0" data-action="<?= $router->route("report.find"); ?>" data-update
                            data-id="<?= $report->getId(); ?>">
                        Editar
                    </button>
                </div>

                <div class="py-1" role="none">
                    <button type="button" class="text-red-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1"
                            id="menu-item-1" data-action="<?= $router->route("report.delete"); ?>" data-delete
                            data-id="<?= $report->getId(); ?>">
                        Excluir
                    </button>
                </div>
            </div>
        </div>
    </div>
</article>