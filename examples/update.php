<?php

require __DIR__ . "/../vendor/autoload.php";

use Advvm\Models\User;

$user = (new User())->findById(9);
$user->email = "adm9@adm.adm";

if (!$user->save())
    echo $user->fail;

echo '<pre>';
    var_dump($user);
echo '</pre>';
