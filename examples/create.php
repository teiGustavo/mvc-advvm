<?php

require __DIR__ . "/../vendor/autoload.php";

use Advvm\Models\User;

$user = new User();
$user->email = "users@users.users";
$user->senha = password_hash("users", PASSWORD_DEFAULT);

/* if (!$user->save())
    echo "O email já existe!"; */

$user->save();

echo "<pre>";   
    var_dump($user);
echo "</pre>";
