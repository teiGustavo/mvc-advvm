<?php

require __DIR__ . "/../../vendor/autoload.php";

use Advvm\Models\User;
use Advvm\Models\Report;

$modelUser = new User();

$users = $modelUser->find()->fetch(true);

foreach ($users as $user) {
    echo '<pre>';
        var_dump('User', $user->data());
    echo '</pre>';  
}

$modelReport = new Report();
$reports = $modelReport->find()->limit(5)->fetch(true);

foreach ($reports as $report) {
    echo '<pre>';
        var_dump('Report', $report->data());
    echo '</pre>';
}