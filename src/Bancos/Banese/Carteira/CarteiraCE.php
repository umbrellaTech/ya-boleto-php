<?php

namespace Umbrella\YaBoleto\Bancos\Banese\Carteira;

use Umbrella\YaBoleto\CarteiraInterface;

/**
 * @author Victor Felix <victor.dreed@gmail.com>
 * Class CarteiraCE
 * @package Umbrella\YaBoleto\Bancos\Banese\Carteira
 */
class CarteiraCE implements CarteiraInterface
{
    public function getNumero()
    {
        return "1";
    }
}
