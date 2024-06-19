<?php

use Dotenv\Dotenv;


$dotenv = Dotenv::createImmutable(dirname(__FILE__, 3));
$dotenv->load();


require 'constants.php';
