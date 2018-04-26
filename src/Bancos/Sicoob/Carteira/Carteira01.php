<?php

namespace Umbrella\YaBoleto\Bancos\Sicoob\Carteira;

use Umbrella\YaBoleto\CarteiraInterface;

/**
 * Class Carteira01
 *
 * @author Victor Felix <victorfelix.dev@gmail.com>
 * @package Umbrella\YaBoleto\Bancos\Sicoob\Carteira
 */
class Carteira01 implements CarteiraInterface
{
    /**
     * Modalidade da Carteira01
     * Default - 01 Simples com Registro
     *
     * @var string
     */
    private $modalidade;

    public function __construct($modalidade = '01')
    {
        $this->modalidade = $modalidade;
    }

    /**
     * Retorna o número da Carteira01
     *
     * @return string
     */
    public function getNumero()
    {
        return '1';
    }

    /**
     * Retorna a modalidade da Carteira 01
     *
     * @return string
     */
    public function getModalidade()
    {
        return $this->modalidade;
    }
}
