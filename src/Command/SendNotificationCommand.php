<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

use App\Service\NotificationService;
use App\Util\Utils;

use App\Entity\User;

class SendNotificationCommand extends Command
{
    protected static $defaultName = 'app:send-notification';
    
    private $notificationSrv;
    private $utils;

    public function __construct(NotificationService $notificationSrv, Utils $utils) 
    {
        $this->notificationSrv = $notificationSrv;
        $this->utils = $utils;

        parent::__construct();
    }

    protected function configure(): void
    {

        $this->addArgument('userId', InputArgument::REQUIRED, 'Id de un usuario existente.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // TODO: Creando un usuario falso
        $mobUser = new User();
        $mobUser->getMobUser();

        // TODO: Generamos un texto aleatorio
        $rndTxt = $this->utils->getRndText(14) . '.';

        // TODO: Hacer la comprobación en la base de datos, extrayendo un usuario real.
        //   Por lo pronto se usará el mobUser creado un poco más arriba
        if ($mobUser->getId() != $input->getArgument('userId')) {
            throw new \Exception("El usuario expecificado no existe.");
        }

        // Llamamos al servicio de notificaciones usando el provider SES y guardamos el
        //   resultado en una variable
        $result = $this->notificationSrv->notify($mobUser, $rndTxt, ['SES']);

        $output->writeln([
            'SES SERVICE:',
            '-------------------------',
            '',
            'Id: ' . $mobUser->getId(),
            'Email: ' . $mobUser->getEmail(),
            'Message: ' . $rndTxt,
            'Result: ' . ($result ? "true": "false"),
        ]);

        return Command::SUCCESS;
    }
}