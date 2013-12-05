<?php

namespace Umbrella\Ya\Boleto\Tests\Mock;

use Umbrella\Ya\Boleto\Carteira\ICarteira;

/**
 * Description of Carteira
 *
 * @author mikhail
 */
class Carteira implements ICarteira {

    private $numero;

    public function getNumero()
    {
        return $this->numero;
    }

    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

}
