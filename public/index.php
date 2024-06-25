<?php

session_start();

use Advvm\Library\Session;

require __DIR__ . "/../vendor/autoload.php";

require __DIR__ . '/../src/config/bootstrap.php';

require __DIR__ . '/../routes/web.php';

Session::removeFlash();
