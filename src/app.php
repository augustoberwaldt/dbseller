<?php

require_once '../vendor/autoload.php';

$output = new Dbseller\OutputConsole();

//\Dbseller\BackgroundProcess::open("php -S 0.0.0.0:8000 run.php");
//\Dbseller\BackgroundProcess::open("curl http://localhost:8000");


do {

    echo "+----------------------------------------+\n";
    echo "|                Menu Task               |\n";
    echo "+----------------------------------------+\n";
    echo "|1 - Cadastrar task                      |\n";
    echo "|2 - Editar task                         |\n";
    echo "|3 - Deletar task                        |\n";
    echo "|4 - Lista de task                       |\n";
    echo "|5 - Sair                                |\n";
    echo "+----------------------------------------+\n";

    $option = readline(":\n");
    $jobService = new Dbseller\Service\JobService();

    switch ($option) {
        case '1':
            $args = [];
            $args['title'] = readline("Informe um titulo para tarefa :\n");
            $args['time']  = readline("Informe a frêquencia da tarefa exemplo(* * * * *) : \n");
            $args['exec']  = readline("Informe caminho da tarefa :\n");

            try {
                $jobService->create($args);
                echo $output->getColoredString("Tarefa cadastrada com sucesso !", 'green'). "\n";
            } catch (\Exception $e) {
                echo $output->getColoredString($e->getMessage(), 'red') . "\n";
            }

            break;
        case '2':

            break;
        case '3':

            try {
                $jobService->remove();
                echo $output->getColoredString("Tarefa excluida com sucesso !", 'green'). "\n";
            } catch (\Exception $e) {
                echo $output->getColoredString($e->getMessage(), 'red') . "\n";
            }

            break;

        case '4':

            break;

        default :
            throw new InvalidArgumentException("Opcao invalida");
    }

    readline();

} while($option != 4);


