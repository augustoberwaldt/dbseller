<?php

namespace Dbseller\Service;

use Dbseller\Repository\JobRepository;
use Dbseller\Entity\Job;

/**
 * Classe responsável
 *
 * @author Augusto Berwaldt <augusto.marlon@moovin.com.br>
 */
class JobService
{
    /**
     * @var JobRepository
     */
    private $jobRepository;

    /**
     * JobService constructor.
     */
    public function __construct()
    {
        $this->jobRepository = new JobRepository();

    }

    /**
     * Atualiza uma job no banco
     *
     * @param Job $job
     */
    public function update(\Dbseller\Entity\Job $job, $filter)
    {
        $this->jobRepository->save($job, $filter);
    }

    /**
     * Busca todas jobs
     */
    public function getAll()
    {
       return $this->jobRepository->find([]);
    }

    /**
     * Adiciona umajob
     *
     * @param $data
     * @throws \Exception
     */
    public  function create($data)
    {

        if (empty($data['title'])) {
            throw new  \InvalidArgumentException("Titulo não informado !");
        }

        if (empty($data['time'])) {
            throw new  \InvalidArgumentException("Frêquencia não informada !");
        }

        if (empty($data['exec'])) {
            throw new  \InvalidArgumentException("Caminho da tarefa não expecificado !");
        }

        if ($this->validateFormatTime($data['time'])) {
            throw new  \InvalidArgumentException("Formato errado da frêquencia, (* * * * *) !");
        }

        $job = new Job();

        $job->setTitle($data['title']);
        $job->setCreated(date("Y-m-d H:i:s"));
        $job->setPathExec($data['exec']);
        $job->setTimer($data['time']);

        $this->jobRepository->save($job);
    }

    /**
     * Valida formato da frequencia da job
     *
     * @param $string
     * @return bool
     */
    public function validateFormatTime($string)
    {
        preg_match( "/^((?:[1-9]?\d|\*)\s*(?:(?:[\/-][1-9]?\d)|(?:,[1-9]?\d)+)?\s*){5}$/",
              $string
            , $matches);

        return empty($matches) ? false : true;
    }

    /**
     * Remove do banco uma job
     *
     * @param Job $job
     */
    public  function removeById($id)
    {
        print $id;
        $this->jobRepository->delete(['_id'=> $id]);
    }


}