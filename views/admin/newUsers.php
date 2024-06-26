<?php
$this->layout("../_theme", ["title" => $title]);
?>

<?= $this->start('css'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<?= $this->stop(); ?>

<div class="container-sm bg-dark rounded-3 p-5">
    <h1 class="fs-5">Aprovar Usuários</h1>

    <?php if ($users) : ?>

        <div class="container-sm mt-5 overflow-y-scroll" style="max-height: 300px;">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <td scope="col">Email</td>
                        <td scope="col">Cargo</td>
                        <td scope="col">Ações</td>
                    </tr>
                </thead>

                <tbody>

                    <?php if (!empty($users)) :
                        foreach ($users as $user) :
                            $this->insert("../_fragments/tr-user", ["user" => $user]);
                        endforeach;
                    else :
                    ?>

                        <p>Erro ao listar os usuários!</p>

                    <?php endif; ?>

                </tbody>
            </table>
        </div>

    <?php else : ?>

        <p class="mt-5 mb-0">Não há usuários cadastrados!</p>

    <?php endif; ?>
</div>

<?php $this->insert("../_fragments/update-user", ["formAction" => $router->route('user.update')]); ?>

<?php $this->start('js'); ?>
<script src="<?= url('/public/assets/js/pages/admin/newUsers.js'); ?>"></script>
<?php $this->stop(); ?>