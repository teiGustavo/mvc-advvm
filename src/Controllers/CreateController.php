<?php

namespace Advvm\Controllers;

use CoffeeCode\Router\Router;
use League\Plates\Engine;

class CreateController
{
    protected array $data;

    public function __construct(
        protected Router $router,
        private Engine $view
    ) {
        $this->view->setDirectory($this->view->getDirectory() . '/create');
    }

    public function selectMonth(): void
    {
        $params = [
            "title" => "Selecionar Mês | " . SITE
        ];

        echo $this->view->render("month", $params);
    }

    public function reportRegistration(array $data): void
    {
        $data = filter_var_array($data, FILTER_DEFAULT);

        if (empty($data["date"])) {
            echo $this->router->redirect("create.selectMonth");

            return;
        }

        $date = $data["date"];

        $lastDayOfMonth = date("t", strtotime($date));
     
        $params = [
            "title" => "Cadastrar | " . SITE,
            "date" => $date,
            "minDate" => $date . '-01',
            "maxDate" => $date . '-' . $lastDayOfMonth
        ];

        echo $this->view->render("registration", $params);
    }
}
