<?php

namespace Umbrella\YaBoleto\Bancos\Sicoob;

use Umbrella\YaBoleto\AbstractBanco;

/**
 * Classe que representa o Banco do SICOOB
 *
 * @author Victor Félix <victorfelix.dev@gmail.com>
 * @package Umbrella\YaBoleto\Bancos\Sicoob
 */
class Sicoob extends AbstractBanco
{
    /**
     * Inicializa uma nova instância da classe.
     *
     * @param string $agencia
     * @param string $conta
     */
    public function __construct($agencia, $conta)
    {
        $numero = '756';
        $nome = 'Banco Cooperativo do Brasil SA - SICOOB';
        parent::__construct($numero, $nome, $agencia, $conta);
    }
}
