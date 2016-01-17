<?php

namespace Umbrella\YaBoleto\Calculator;

use Umbrella\YaBoleto\AbstractBoleto;

interface CodigoBarrasCalulatorInterface
{
    public function calculate(AbstractBoleto $boleto);
}