<?php
namespace Dbseller\Repository;

/**
 * Classe responsável por realizar consulta no banco
 *
 * @author Augusto Berwaldt <augusto.marlon@moovin.com.br>
 */
class JobRepository extends Repository
{


    /**
     * Realiza busca da entity pelo parametro
     *
     * @param $search
     */
    public function find(array $search = [])
    {
        $result = $this->repository
            ->setCollectionName('Job')
            ->find($search);

        return $this->convertResultToObject(\Dbseller\Entity\Job::class, $result);
    }

    /**
     * Persiste  um registro no banco
     *
     * @param \DBseller\Entity\Job $job
     * @return boolean | integer
     */
    public function save(\DBseller\Entity\Job  $job)
    {
        return $this->repository
            ->setCollectionName('Job')
            ->persist([
                'title'   => $job->getTitle(),
                'created' => $job->getCreated(),
                'type'    => $job->getType(),
                'time'    => $job->getTimer(),
                'pathExec'=> $job->getPathExec()
            ]);
    }



}