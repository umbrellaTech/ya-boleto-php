<?php

namespace Umbrella\YaBoleto\Bancos\Sicoob\Boleto;

use ArrayObject;
use Umbrella\YaBoleto\AbstractBoleto;

/**
 * Classe que representa o boleto do SICOOB
 *
 * @author Victor Felix <victorfelix.dev@gmail.com>
 * @package Umbrella\YaBoleto\Bancos\Sicoob\Boleto
 */
class Sicoob extends AbstractBoleto
{
    /**
     * @var string
     */
    protected $parcela = '001';

    /**
     * @var string
     */
    protected $modalidade;

    /**
     * @return string
     */
    public function getParcela()
    {
        return $this->parcela;
    }

    /**
     * @param string $parcela
     * @return Sicoob
     */
    public function setParcela($parcela)
    {
        $this->parcela = $parcela;

        return $this;
    }

    /**
     * Retorna os dados do boleto
     *
     * @return ArrayObject
     */
    protected function setDadosBoleto(array $data)
    {
        $data['Parcela'] = $this->getParcela();
        $data['Modalidade'] = $this->convenio->getCarteira()->getModalidade();

        return parent::setDadosBoleto($data);
    }

    /**
     * Retorna a conta formatada
     *
     * @return string
     */
    protected function getContaFormatada()
    {
        return substr($this->convenio->getBanco()->getConta(), 0, 7);
    }
}
