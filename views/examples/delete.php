<?php

require __DIR__ . "/../../vendor/autoload.php";

use Advvm\Models\User;

$user = (new User())->findById(9);

if ($user)
    $user->destroy();

echo '<pre>';
var_dump($user);
echo '</pre>';
