<?php

namespace Advvm\Models;

use CoffeeCode\DataLayer\DataLayer;

class Report extends DataLayer
{
    public function __construct()
    {
        parent::__construct("reports", ["date", "report", "type", "amount"], "id", false);
    }
}
