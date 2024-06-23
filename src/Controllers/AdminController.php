<?php

namespace Advvm\Controllers;

use CoffeeCode\Router\Router;
use League\Plates\Engine;
use Advvm\Repositories\User\UserRepositoryInterface;

class AdminController
{
    public function __construct(
        protected Router $router,
        private Engine $view,
        private UserRepositoryInterface $repository,
    ) {
        $this->view->setDirectory($this->view->getDirectory() . '/admin');
    }

    public function index(): void
    {
        $params = [
            'title' => "Admin | " . SITE,
            'users' => $this->repository->getAllUsers()
        ];

        echo $this->view->render("newUsers", $params);
    }
}
