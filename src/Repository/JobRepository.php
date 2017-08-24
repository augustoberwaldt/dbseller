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
     * @const  string COLLECTION  nome da colecao no banco
     */
    const COLLECTION = 'Job';

    /**
     * Realiza busca da entity pelo parametro
     *
     * @param $search
     */
    public function find(array $search = [])
    {
        $result = $this->repository
            ->setCollectionName(self::COLLECTION)
            ->find($search);

        return $this->convertResultToObject(\Dbseller\Entity\Job::class, $result);
    }

    /**
     * Persiste  um registro no banco
     *
     * @param \DBseller\Entity\Job $job
     * @return boolean | integer
     */
    public function save(\DBseller\Entity\Job  $job, $filter = [])
    {
        $data = [
            'lastExec'=> $job->getLastExec(),
            'title'   => $job->getTitle(),
            'created' => $job->getCreated(),
            'type'    => $job->getType(),
            'time'    => $job->getTimer(),
            'pathExec'=> $job->getPathExec()
        ];

        if (!empty($job->getId()) && !empty($filter)) {
            return $this->repository
                        ->setCollectionName(self::COLLECTION)
                        ->update($data, $filter);
        }

        return $this->repository
                    ->setCollectionName(self::COLLECTION)
                    ->persist($data);
    }


}