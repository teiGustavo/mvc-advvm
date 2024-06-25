<?php

namespace Advvm\Models;

use CoffeeCode\DataLayer\DataLayer;

class User extends DataLayer
{
    public function __construct()
    {
        parent::__construct("users", ["email", "password"], "id", false);
    }

    //    public function save(): bool
    //     {
    //         //Verifica se houve algum erro durante as validações ou durante o salvamento (persistência de dados)
    //         if (!$this->validateEmail() || !$this->validatePassword() || !parent::save())
    //             return false;

    //         return true;
    //     } 

    // protected function validateEmail(): bool
    // {
    //     //Verifica se o e-mail está no formato correto
    //     if (empty($this->email) || !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
    //         //Caso o email seja nulo (vazio) ou não siga os padrões, define uma Exception do PDO
    //         $this->fail = new PDOException("Informe um e-mail válido!");
    //         return false;
    //     }

    //     //Verifica se o email já é existente na base de dados
    //     $userByEmail = null;

    //     if (!$this->id) {
    //         //Binda os parâmetros da query PDO
    //         $params = http_build_query(["email" => "{$this->email}"]);
    //         $userByEmail = $this->find("email = :email", $params)->count();
    //     } else {
    //         //Binda os parâmetros da query PDO
    //         $params = http_build_query(["email" => "{$this->email}", "id" => "{$this->id}"]);
    //         $userByEmail = $this->find("email = :email AND id != :id", $params)->count();
    //     }

    //     //Verifica se o email foi encontrado
    //     if ($userByEmail) {
    //         //Caso o email tenha sido encontrado, uma Exception PDO é gerada 
    //         $this->fail = new PDOException("O e-mail informado já está em uso");
    //         return false;
    //     }

    //     return true;
    // }

    // public function validatePassword(): bool
    // {
    //     //Verifica se a senha esta no formato correto
    //     if (empty($this->password) || (strlen($this->password) < 5)) {
    //         //Caso a senha seja nula ou não cumpra o mínimo de caracteres, uma Exception PDO é gerada
    //         $this->fail = new PDOException("Informe uma senha com pelo menos 5 caracteres");
    //         return false;
    //     }

    //     //Verifica através do gerenciador de senhas do PHP se a senha necessita de atualização
    //     if (password_needs_rehash($this->password, PASSWORD_DEFAULT)) {
    //         $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    //     }

    //     return true;
    // }
}
