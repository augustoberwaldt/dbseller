<?php
namespace Dbseller\Repository;

/**
 * Created by PhpStorm.
 * User: harley
 * Date: 22/08/17
 * Time: 17:49
 */
class JobRepository extends Repository
{



    public function find($search)
    {
        $this->repository->find($search);
    }


    public function persist($data)
    {
        $this->repository
            ->setCollectionName('Job')
            ->persist($data);
    }

}