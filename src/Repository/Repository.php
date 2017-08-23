<?php
/**
 * Created by PhpStorm.
 * User: harley
 * Date: 23/08/17
 * Time: 13:31
 */

namespace Dbseller\Repository;

use  Dbseller\Provider\ProviderMongo;

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

}