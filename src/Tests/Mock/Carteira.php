<?php

namespace Umbrella\Ya\Boleto\Tests\Mock;

use Umbrella\Ya\Boleto\Carteira\CarteiraInterface;

/**
 * Description of Carteira
 *
 * @author mikhail
 */
class Carteira implements CarteiraInterface
{
    private $numero;

    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param integer|null $numero
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    }
}
