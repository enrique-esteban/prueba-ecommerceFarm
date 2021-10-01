<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\User;

use App\Service\NotificationService;
use App\Util\Utils;

class SiteController extends AbstractController
{
    private $notificationSrv;
    private $utils;

    public function __construct(NotificationService $notificationSrv, Utils $utils) 
    {
        // Añadimos la dependencia al servidor de notificaciones, debido a que la opción
        //   autowire está a true se cargará automaticamente como servicio.
        $this->notificationSrv = $notificationSrv;
        $this->utils = $utils;
    }

    /**
     * Envia una mensaje y el usuario actualmente logueado al servicio de notificacines 
     */
    public function sendNotification($id): Response
    {
        // TODO: Creando un usuario falso
        $mobUser = new User();
        $mobUser->getMobUser();
        dump($mobUser);

        // TODO: Generamos un texto aleatorio
        $rndTxt = $this->utils->getRndText(14) . '.';
        dump($rndTxt);

        // TODO: Hacer la comprobación en la sesión actual.
        //   Por lo pronto se usará el mobUser creado un poco más arriba
        if ($mobUser->getId() != $id) {
            throw new \Exception("El usuario logueado no se encuentra en la BD.");
        }

        // Llamamos al servicio de notificaciones usando el provider SES y guardamos el
        //   resultado en una variable
        $result = $this->notificationSrv->notify($mobUser, $rndTxt, ['SMTP']);

        return $this->render('front/notification.html.twig', [
            'user' => $mobUser,
            'message' => $rndTxt,
            'result' => $result
        ]);
    }

    /**
     * Genera un texto aleatorio con una longitud especifica
     *   opcionalmante se puede pasar un string con el conjunto de caracteres que se quieran usar
     */
    private function getRndText ($leng, $characterList = '0123456789abcdefghijklmnopqrstuvwxyz ') {
        $rndTxt = '';
    
        for ($i = 0; $i < $leng; $i++) {
            $index = rand(0, strlen($characterList) - 1);
            $rndTxt .= $characterList[$index];
        }
    
        return $rndTxt;
    }
}
