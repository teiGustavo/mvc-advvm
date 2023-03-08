<?php

namespace Advvm\Models;

use CoffeeCode\DataLayer\DataLayer;

class Report extends DataLayer
{
    //Responsável por mapear a tabela "Reports" do BD
    public function __construct()
    {
        //Instancia o construtor da Classe pai (DataLayer)
        parent::__construct("reports", ["data_report", "historico", "tipo", "valor"], "cod_lancamento", false);
    }
}
