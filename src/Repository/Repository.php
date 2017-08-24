<?php

namespace Dbseller\Repository;

use  Dbseller\Provider\ProviderMongo;

/**
 * Classe abstract modelo para prover conexão
 *
 * @author Augusto Berwaldt <augusto.marlon@moovin.com.br>
 */
class Repository
{

    /**
     * @var \Dbseller\Provider\DriverMongo
     */
    protected $repository;

    /**
     * @const DATABASE Nome da base de dados
     */
    const  DATABASE  = 'DBseller';

    /**
     * Repository constructor.
     */
    public function  __construct()
    {
        $this->repository = ProviderMongo::getConnection(self::DATABASE);
    }

    /**
     * Converte um array retornado do mongo para um obejeto Entity
     *
     * @param array $order
     * @return Order
     */
    protected function convertResultToObject($entity, array $iterator)
    {

        $list = [];
        foreach ($iterator as $item) {
            $object =  new $entity();
            foreach ($item as $column => $value) {
                $method = 'set'.ucfirst($column);
                if (method_exists($object, $method)) {
                    call_user_func([$object, $method], $value);
                }
            }

            $list[] = $object;
        }

        return $list;
    }

}