<?php

namespace App\Util;

class Utils
{
    /**
     * Genera un texto aleatorio con una longitud especifica
     *   opcionalmante se puede pasar un string con el conjunto de caracteres que se quieran usar
     */
    public function getRndText ($leng, $characterList = '0123456789abcdefghijklmnopqrstuvwxyz '): string {
        $rndTxt = '';
    
        for ($i = 0; $i < $leng; $i++) {
            $index = rand(0, strlen($characterList) - 1);
            $rndTxt .= $characterList[$index];
        }
    
        return $rndTxt;
    }
}