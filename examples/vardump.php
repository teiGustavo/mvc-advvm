<?php

namespace Examples;

class Vardump
{
    public function echo($var)
    {
        echo "<pre>";
            var_dump($var);
        echo "</pre>";
    }
}
