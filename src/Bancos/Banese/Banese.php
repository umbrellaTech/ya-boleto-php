<?php

namespace Umbrella\YaBoleto\Bancos\Banese;

use Umbrella\YaBoleto\AbstractBanco;

/**
 * Classe que representa o Banco do Estado de Sergipe - BANESE
 *
 * @author Victor Félix <victor.dreed@gmail.com>
 * @package Umbrella\YaBoleto\Bancos\Banese
 */
class Banese extends AbstractBanco
{
    /**
     * Inicializa uma nova instância da classe.
     *
     * @param string $agencia
     * @param string $conta
     */
    public function __construct($agencia, $conta)
    {
        $numero = "047";
        $nome = "Banco do Estado de Sergipe - BANESE";
        parent::__construct($numero, $nome, $agencia, $conta);
    }
}