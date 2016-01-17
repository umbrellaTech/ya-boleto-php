<?php

namespace Umbrella\YaBoleto\Tests;

use Umbrella\YaBoleto\AbstractBoleto;
use Umbrella\YaBoleto\Calculator\CodigoBarrasCalculator;
use Umbrella\YaBoleto\Calculator\LinhaDigitavelCalulator;

trait LinhaDigitavelTrait
{
    public function getLinhaDigitavel(AbstractBoleto $boleto)
    {
        $codigoBarrasCalculator = new CodigoBarrasCalculator();
        $codigoBarras = $codigoBarrasCalculator->calculate($boleto);

        $linhaDigitavelCalculator = new LinhaDigitavelCalulator();

        return $linhaDigitavelCalculator->calculate($codigoBarras);
    }
}