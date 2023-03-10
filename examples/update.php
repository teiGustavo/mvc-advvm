<?php

require __DIR__ . "/../vendor/autoload.php";

use Advvm\Models\User;

$user = (new User())->findById(2);
$user->senha = password_hash("adm", PASSWORD_DEFAULT);

if (!$userId = $user->save())
    echo $user->fail->getMessage();

echo '<pre>';
    var_dump($user);
echo '</pre>';
