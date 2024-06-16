<?php
$this->layout("../../_theme", ["title" => $title]);
?>

<div id="form">
    <div class="mt-10 sm:mt-0">
        <div class="md:gap-6">
            <div class="md:col-span-1 my-8">
                <div class="px-4 sm:px-0">
                    <h3 class="text-base font-semibold leading-6 text-gray-900">Cadastro de Relatório</h3>
                </div>
            </div>
            <div class="mt-5 md:col-span-2 md:mt-0">

                <form action="<?= $router->route("cadastrar.create"); ?>" method="POST">
                    <div class="overflow-hidden sm:rounded-md" id="personal_info">
                        <div class="px-4 py-5 sm:p-6" id="personal_info">
                            <div class="grid grid-cols-2 gap-6">

                                <div>
                                    <div class="col-span-2 sm:col-span-2 mb-5">
                                        <label for="dia" class="block text-sm font-medium leading-6 text-gray-900">Dia: </label>
                                        <input type="date" name="date" id="dia" autocomplete="dia" min="<?= $date . "-01"; ?>" max="<?= $date . "-" . $lastDay; ?>" class="mt-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>

                                    <div class="col-span-2 sm:col-span-2">
                                        <label for="report" class="block text-sm font-medium leading-6 text-gray-900">Lançamento: </label>
                                        <input type="text" name="report" id="report" autocomplete="report" class="mt-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div>
                                    <div class="col-span-2 sm:col-span-2 mb-5">
                                        <label for="price" class="block text-sm font-medium leading-6 text-gray-900">Valor</label>
                                        <div class="relative mt-2 rounded-md shadow-sm">
                                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                                <span class="text-gray-500 sm:text-sm">R$</span>
                                            </div>
                                            <input type="text" name="amount" id="amount" class="block w-full rounded-md border-0 py-1.5 pl-7 pr-20 text-gray-900
                                                   ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2
                                                   focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="0.00">
                                        </div>
                                    </div>

                                    <div class="col-span-2 sm:col-span-2">
                                        <label for="type" class="block text-sm font-medium leading-6 text-gray-900 mb-2">Tipo: </label>
                                        <select name="type" id="type" class="text-gray-900 placeholder:text-gray-400 rounded-md">
                                            <option value="Automático">Automático</option>
                                            <option value="Entrada">Entrada</option>
                                            <option value="Saída">Saída</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="px-4 py-3 text-right sm:px-6" id="div_Button">
                            <a href="<?= $router->route("cadastrar.selecionarMes"); ?>">
                                <button type="button" name="btnExit" value="sair" id="btnExit" class="inline-flex justify-center rounded-md bg-indigo-600 py-2 px-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Sair</button>
                            </a>

                            <button type="submit" name="btnSubmit" value="cadastrar" id="btn" class="inline-flex justify-center rounded-md bg-indigo-600 py-2 px-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Cadastrar</button>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<?php $this->start("js"); ?>
<script>
    function updateFormCss() {
        $("#personal_info").css("border-radius", "15px");

        $("h3, p, label").css("color", "white");

        $("input").addClass("bg-gray-200");

        $("#form").css("max-widht", "1000px");
        $("#form").css("width", "60%");
        $("#form").css("min-width", "350px");
        $("#form").css("border-radius", "20px");
        $("#form").css("padding", "50px");
        $("#form").css("background", "#2f2841");

        $("input").css("padding", "10px");
        $("input").css("padding-left", "35px");

        $("#dia").css("padding-bottom", "8px");

        $("#type").css("width", "100%");
        $("#type").css("padding", "9.7px");

        $("#div_Button").css("text-align", "center");

        $("#btn").css("background", "#201b2c");
        $("#btn").css("padding", "15px");

        $("#btnExit").css("background", "#b22222");
        $("#btnExit").css("padding", "15px");
    }

    updateFormCss();
</script>
<?php $this->stop(); ?>