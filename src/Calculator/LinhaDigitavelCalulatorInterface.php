<?php

namespace Umbrella\YaBoleto\Calculator;

use Umbrella\YaBoleto\CodigoBarras;

interface LinhaDigitavelCalulatorInterface
{
    public function calculate(CodigoBarras $codigoBarras);
}