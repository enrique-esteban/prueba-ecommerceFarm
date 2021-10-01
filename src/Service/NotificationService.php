<?php

namespace App\Service;

use App\Service\Provider\SmtpProvider;
use App\Service\Provider\SesProvider;

class NotificationService
{
    private $smtpProvider;
    private $sesProvider;

    public function __construct(SmtpProvider $smtpProvider, SesProvider $sesProvider) 
    {
        $this->smtpProvider = $smtpProvider;
        $this->sesProvider = $sesProvider;
    }

    /**
     * Usa uno de los proveedores de notificacion para enviar un mensage:
     *   - Estos proveedores son SMTP y SES
     *   - Por defecto usa el servicio SMTP
     *   - Se podrán pasar tanto en mayusculas como en minisculas
     *   - Si no encuentra un proveedor satifastorio se envia una excepcion 
     */
    public function notify($user, $message, $providers = ["SMTP"])
    {
        foreach ($providers as $provider) {
            // Quitamos posibles espacios en blanco y ponemos el nombre del proveedor en mayusculas
            $provider = trim($provider);
            $provider = strtoupper($provider);

            switch ($provider) {
                case "SMTP":
                    $this->smtpProvider->send($user->getEmail(), $message);
                    break;
                case "SES":
                    $this->sesProvider->send($user->getEmail(), $message);
                    break; 
                default: // TODO: Mejorar el manejador de errores
                    throw new Exception("Proveedor incorrecto");
                    break;
            }
        }
    }
}