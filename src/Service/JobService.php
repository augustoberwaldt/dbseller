<?php

namespace Dbseller\service;

use Dbseller\Repository\JobRepository;
/**
 * Created by PhpStorm.
 * User: harley
 * Date: 22/08/17
 * Time: 16:56
 */
class JobService
{


    public  function create($data)
    {

        if (empty($data['title'])) {
            throw new  \Exception("Titulo não informado !");
        }

        if (empty($data['time'])) {
            throw new  \Exception("Frequencia não informada !");
        }

        if (empty($data['exec'])) {
            throw new  \Exception("Caminho da tarefa não expecificado !");
        }

        $jobRepository = new JobRepository();

        $jobRepository->persist($data);
    }


}