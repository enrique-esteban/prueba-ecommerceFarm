<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\User;

use App\Service\NotificationService;

class SiteController extends AbstractController
{
    private $notificationSrv;

    public function __construct(NotificationService $notificationSrv) 
    {
        $this->notificationSrv = $notificationSrv;
    }

    /**
     * Carga la página de inicio.
     */
    // public function index(): Response
    // {
    //     //return $this->render('index.html.twig');
    // }

    /**
     * Envia una mensaje y el usuario actualmente logueado al servicio de notificacines 
     */
    public function sendNotification($id): Response
    {
        // Creando un usuario falso
        $mobUser = new User();
        $mobUser->setId($id);
        $mobUser->setUsername("enrique");
        $mobUser->setEmail("ense.esteban@gmail.com");
        dump($mobUser);

        // Generamos un texto aleatorio
        $rndTxt = $this->getRndText(14) . '.';
        dump($rndTxt);

        $this->notificationSrv->notify($mobUser, $rndTxt);

        return $this->render('front/notification.html.twig');
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
