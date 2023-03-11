<?php
  $this->layout("../_theme", ["title" => $title]);
?>

<?php $this->start("sidebar"); ?>
  <a href="<?= $router->route("advvm.home") ?>">Voltar</a>
<?php $this->stop(); ?>

<div id="form">
  <div class="mt-10 sm:mt-0">
    <div class="md:gap-6">
      <div class="md:col-span-1 my-8">
        <div class="px-4 sm:px-0">
          <h3 class="text-base font-semibold leading-6 text-gray-900">Informações Pessoais</h3>
          <p class="mt-1 text-sm text-gray-600">Use suas credenciais para se conectar.</p>
        </div>
      </div>
      <div class="mt-5 md:col-span-2 md:mt-0">

        <form action="<?= $router->route("auth.post");?>" method="POST">
          <div class="overflow-hidden shadow sm:rounded-md" id="personal_info">
            <div class="bg-gray-400 px-4 py-5 sm:p-6" id="personal_info">
              <div class="grid grid-cols-4 gap-6">

                <div class="col-span-4 sm:col-span-4">
                  <label for="email-address" class="block text-sm font-medium leading-6 text-gray-900">Email: </label>
                  <input type="text" name="email" id="email-address" autocomplete="email"
                    class="mt-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>

                <div class="col-span-4 sm:col-span-4">
                  <label for="email-address" class="block text-sm font-medium leading-6 text-gray-900">Senha: </label>
                  <input type="password" name="password" id="email-address" autocomplete="password"
                    class="mt-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>

              </div>
            </div>

            <div class="bg-gray-400 px-4 py-3 text-right sm:px-6" id="div_Button">
              <button type="submit" name="btnSubmit" value="logar"
                class="inline-flex justify-center rounded-md bg-indigo-600 py-2 px-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Logar</button>
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
      $("#form").css("width", "40%");
      $("#form").css("min-width", "350px");
      $("#form").css("border-radius", "20px");
      $("#form").css("padding", "50px");
      $("#form").css("background", "#514869");

      $("input").css("padding", "10px");

      $("#div_Button").css("text-align", "center");
    }

    updateFormCss();
  </script>
<?php $this->stop(); ?>