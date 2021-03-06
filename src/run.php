<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../vendor/autoload.php';

$jobService = new Dbseller\Service\JobService();


while(1) {

    $listJobs = $jobService->getAll();

    foreach ($listJobs as $job) {
        $exec = false;

        $now = strtotime('now');

        $type = 60;// default

        $times = explode(' ', $job->getTimer());

        $mapTime =  [
             0 => 60, // minutos
             1 => 360, // horas
             2 => 86.400 // dia
        ];

        foreach ($times as $index => $timeJob) {

            if ($timeJob != '*') {
                $type = $mapTime[$index];
            }

            $now  = strtotime('now');
            $diff = ($now - $job->getLastExec()) / $type;

            if ($diff == $job->getTimer() || $timeJob == '*' || empty($job->getLastExec())) {

                $exec = true;

                if (@file_exists($job->getPathExec())) {
                    $cmd = "php " . $job->getPathExec();
                } else {
                    $cmd = "curl " . $job->getPathExec();
                }
            }

            if ($exec) {

                \Dbseller\BackgroundProcess::open($cmd);
                $job->setLastExec($now);
                $jobService->update($job, [
                    '_id' => $job->getId()
                ]);
            }
        }
    }

}



