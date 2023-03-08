<?php 
    $this->layout("_theme", ["title" => $title]); 
?>

<div class="users">
    <?php if ($users):
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
        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit, laboriosam.</p>

    <?php endif; ?>
</div>