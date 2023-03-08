<?php

require __DIR__ . "/../vendor/autoload.php";

use Advvm\Models\User;

$user = new User();
$user->email = "users@users.users";
$user->senha = "12345";

/* if (!$user->save())
    echo "O email já existe!"; */

$user->save();

echo "<pre>";   
    var_dump($user);
echo "</pre>";
