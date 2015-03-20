<?php namespace Umbrella\YaBoleto\Tests\Mock;

use Umbrella\YaBoleto\CarteiraInterface;

class Carteira implements CarteiraInterface
{
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
