<?php

namespace Umbrella\YaBoleto\Bancos\Banese;

use ArrayObject;
use Umbrella\YaBoleto\AbstractConvenio;

/**
 * Classe que representa o Convênio do Banco BANESE
 *
 * @author Victor Felix <victor.dreed@gmail.com>
 * @package Umbrella\YaBoleto\Bancos\Banese
 */
class Convenio extends AbstractConvenio
{
    /**
     * Gera o campo livre do código de barras.
     *
     * @author Victor Felix <victor.dreed@gmail.com>
     * @param  ArrayObject $data
     * @return $data
     */
    public function gerarCampoLivre(ArrayObject $data)
    {
        $this->alterarTamanho('Conta', 9);
        $this->alterarTamanho('Agencia', 2);
        $this->layout = ":Banco:Moeda:FatorVencimento:Valor:Agencia:Conta:NossoNumero:Banco";
    }

    /**
     * Ajusta o nosso número
     *
     * @author Victor Felix <victor.dreed@gmail.com>
     * @param ArrayObject $data
     * @return ArrayObject
     */
    public function ajustarNossoNumero(\ArrayObject $data)
    {
        $nossoNumero = "0" . $data['Agencia'] . $data['NossoNumero'];
        $data['NossoNumero'] = substr($nossoNumero, 3, 9) . $this->calcularDvNossoNumero($nossoNumero);
        return $data;
    }

    /**
     * Calcula o dígito verificador do Nosso Número do Banco BANESE
     *
     * @author Victor Felix <victor.dreed@gmail.com>
     * @param $nossoNumero
     * @return float
     */
    private function calcularDvNossoNumero($nossoNumero)
    {
        $produto = 2;
        $soma = 0;

        //Separação dos números
        for ($i = 0; $i < strlen($nossoNumero); $i++) {
            //Isolando cada número
            $digito = substr(strrev($nossoNumero), $i, 1);

            //Efetuando a multiplicação do dígito isolado pelo produto
            $soma += (int) $digito * $produto;
            $produto++;
            //Se o valor do produto for maior que 9
            //O produto tem seu valor resetado, ou seja, volta para 2
            $produto = $produto > 9 ? 2 : $produto;
        }

        //Retorna o valor arredondado do resto da soma dividida por 11
        $resto = round(($soma % 11));
        $dv = 0 == $resto || 1 == $resto ? 0 : round(11 - $resto);

        return $dv;
    }
}