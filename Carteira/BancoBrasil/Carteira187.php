<?php

/*
 * The MIT License
 *
 * Copyright 2013 Umbrella Tech.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Umbrella\Ya\Boleto\Carteira\BancoBrasil;

use Umbrella\Ya\Boleto\Carteira\CarteiraInterface;

/**
 * Description of Carteira18
 *
 * @author italo
 */
class Carteira187 implements CarteiraInterface
{

    public $tamanhos = array(
        //Campos comuns a todos os bancos
        'Banco' => 3, //identificação do banco
        'Moeda' => 1, //Código da moeda: real=9
        'DV' => 1, //Dígito verificador geral da linha digitável
        'FatorVencimento' => 4, //Fator de vencimento (Dias passados desde 7/out/1997)
        'Valor' => 10, //Valor nominal do título
        //Campos variávies
        'Agencia' => 4, //Código da agencia, sem dígito
        'Conta' => 8, //Número da conta
        'CodigoCedente' => 7, //Número do convênio fornecido pelo banco
        'DigitoConta' => 1, //Dígito da conta do Cedente
        'NossoNumero' => 10, //Nosso número
        'DigitoNossoNumero' => 5, //Dígito do nosso número
        'Carteira' => 2, //Código da carteira
    );
    protected $layout = ':Banco:Moeda:FatorVencimento:Valor000000:CodigoCedente:NossoNumero:Carteira';
    protected $nossoNumero;

    public function __construct($nossoNumero)
    {
        $this->nossoNumero = $nossoNumero;
    }

    /**
     * Retorna o nosso numero
     * @return string
     */
    public function getNossoNumero()
    {
        return $this->nossoNumero;
    }

    /**
     * Define o nosso numero
     * @param string $nossoNumero
     * @return CarteiraInterface
     */
    public function setNossoNumero($nossoNumero)
    {
        $this->nossoNumero = $nossoNumero;
        return $this;
    }

    public function getLayout()
    {
        return $this->layout;
    }

    public function getNumero()
    {
        return "18-7";
    }

    public function getTamanhos()
    {
        return $this->tamanhos;
    }

}
