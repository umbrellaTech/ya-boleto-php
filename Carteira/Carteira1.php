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

namespace Umbrella\Ya\Boleto\Carteira;

/**
 * Description of Carteira18
 *
 * @author italo
 */
class Carteira1 implements CarteiraInterface
{

    public $tamanhos = array(
        #Campos comuns a todos os bancos
        'Banco' => 3, //identificação do banco
        'Moeda' => 1, //Código da moeda: real=9
        'DV' => 1, //Dígito verificador geral da linha digitável
        'FatorVencimento' => 4, //Fator de vencimento (Dias passados desde 7/out/1997)
        'Valor' => 10, //Valor nominal do título
        #Campos variávies
        'CodigoCedente' => 6, //Código do cedente
        'NossoNumero' => 17, //Nosso número
    );
    protected $layout = ':Banco:Moeda:FatorVencimento:Valor1:CodigoCedente9:NossoNumero';
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
     * @return \Umbrella\Ya\Boleto\Carteira\CarteiraInterface
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
