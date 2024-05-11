<?php 
    $this->layout("_theme", ["title" => $title]); 
?>

<div class="users">
    <?php if (isset($users)):
        foreach ($users as $user):
            ?>

            <article class="users_user">
                <h1>
                    <?= "Email: " . $user->email . "<br>Senha: " . $user->senha ?>
                </h1>
            </article>

            <?php
        endforeach;
    else:
        ?>

        <h4>Não existem usuários cadastrados!</h4>

    <?php endif; ?>
</div>