<?php

namespace Umbrella\YaBoleto\Calculator;

use Umbrella\YaBoleto\CodigoBarras;
use Umbrella\YaBoleto\LinhaDigitavel;
use Umbrella\YaBoleto\Mascara;
use Umbrella\YaBoleto\Type\Number;
use Umbrella\YaBoleto\Type\String;

class LinhaDigitavelCalulator
{
    public function calculate(CodigoBarras $codigoBarras)
    {
        // Campo1 - Posições de 1-4 e 20-24
        $linhaDigitavel = substr($codigoBarras, 0, 4) . substr($codigoBarras, 19, 5)
            // Campo2 - Posições 25-34
            . substr($codigoBarras, 24, 10)
            // Campo3 - Posições 35-44
            . substr($codigoBarras, 34, 10)
            // Campo4 - Posição 5
            . substr($codigoBarras, 4, 1)
            // Campo5 - Posições 6-19
            . substr($codigoBarras, 5, 14);

        $dv1 = Number::modulo10(substr($linhaDigitavel, 0, 9));
        $dv2 = Number::modulo10(substr($linhaDigitavel, 9, 10));
        $dv3 = Number::modulo10(substr($linhaDigitavel, 19, 10));

        $linhaDigitavel = String::putAt($linhaDigitavel, $dv3, 29);
        $linhaDigitavel = String::putAt($linhaDigitavel, $dv2, 19);
        $linhaDigitavel = String::putAt($linhaDigitavel, $dv1, 9);

        $mascara = new Mascara("00000.00000 00000.000000 00000.000000 0 00000000000000");

        return new LinhaDigitavel(String::applyMask($linhaDigitavel, $mascara->getValue()));
    }
}
