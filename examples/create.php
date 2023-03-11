<?php

require __DIR__ . "/../vendor/autoload.php";

use Advvm\Models\User;

$user = new User();
$user->email = "a@a.a";
$user->senha = password_hash("a", PASSWORD_DEFAULT);

/* if (!$user->save())
    echo "O email já existe!"; */

$user->save();

echo "<pre>";   
    var_dump($user);
echo "</pre>";
