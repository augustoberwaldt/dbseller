<?php

namespace Dbseller\Provider;

/**
 * Classe abstract modelo para prover conexão
 *
 * @author Augusto Berwaldt <augusto.marlon@moovin.com.br>
 */
abstract class Provider
{

    /**
     * Metodo responsável por retornar a conexao
     *
     * @param $dbname
     * @return mixed
     */
    public  abstract static  function getConnection($dbname);

}