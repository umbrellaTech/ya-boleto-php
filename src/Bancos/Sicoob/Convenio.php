<?php

namespace Umbrella\YaBoleto\Bancos\Sicoob;

use ArrayObject;
use Umbrella\YaBoleto\AbstractConvenio;

/**
 * Classe que representa o Convênio do Banco SICOOB
 *
 * @author Victor Felix <victor.dreed@gmail.com>
 * @package Umbrella\YaBoleto\Bancos\Sicoob
 */
class Convenio extends AbstractConvenio
{
    /**
     * Gera o campo livre do código de barras.
     *
     * @param  ArrayObject $data
     * @return $data
     */
    public function gerarCampoLivre(ArrayObject $data)
    {
        $this->alterarTamanho('NossoNumero', 7);
        $this->alterarTamanho('Carteira', 1);
        $this->alterarTamanho('Modalidade', 2);
        $this->alterarTamanho('Conta', 7);
        $this->alterarTamanho('Parcela', 3);
        $this->alterarTamanho('Modalidade', 2);

        $this->layout = ':Banco:Moeda:FatorVencimento:Valor:Carteira:Agencia:Modalidade:Conta:NossoNumero:Parcela';

        return $data;
    }

    /**
     * @param ArrayObject $data
     */
    public function ajustarNossoNumero(\ArrayObject $data)
    {
        $dvNossoNumero = $this->calcularDvNossoNumero(
            $this->getBanco()->getAgencia()
            . str_pad($this->getBanco()->getConta(), 10, 0, STR_PAD_LEFT)
            . $data['NossoNumero']
        );

        $this->dvNossoNumero = $dvNossoNumero;
        $data['NossoNumero'] = $data['NossoNumero'] . $dvNossoNumero;
    }

    /**
     * Cálculo do DV do Nosso Número utilizado pelo Banco SICOOB
     *
     * @param $nossoNumero
     * @return int
     */
    private function calcularDvNossoNumero($nossoNumero)
    {
        $referencia = [3,1,9,7];
        $indice = 0;
        $soma = 0;

        for ($i = 0; $i < strlen($nossoNumero); $i++) {
            $soma += $nossoNumero[$i] * $referencia[$indice];
            $indice++;
            $indice = $indice > 3 ? 0 : $indice;
        }

        $resto = $soma % 11;

        return $resto > 1 ? 11 - $resto : 0;
    }

    /**
     * O DV do nosso número faz parte do cálculo da linha digitável
     * e especificamente neste banco, SICOOB, o DV foi setado antes
     * desse método ser chamado, não sendo necessário calcular e setar
     * novamente.
     *
     * @param string $carteira
     * @param string $nossoNumero
     * @param string $ifTen
     * @param string $ifZero
     * @return $this
     */
    public function setDvNossoNumero($carteira, $nossoNumero, $ifTen = 'P', $ifZero = '0')
    {
        return $this;
    }
}
