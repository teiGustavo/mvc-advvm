<?php

namespace Advvm\Controllers;

use League\Plates\Engine;
use League\Plates\Template\Template;

class ReadController
{
    private $templates;

    public function __construct()
    {
        $this->templates = new Engine(__DIR__ . "/../../views");
    }

    public function index()
    {
        $template = $this->templates->make("read");
        
        $template->data([
            "title" => "Leitura | " . SITE,
            "name" => "Gusatvo Teixeira"
        ]);

        echo $template->render();
    }
}

