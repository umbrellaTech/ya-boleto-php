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

namespace Umbrella\Ya\Boleto\Carteira\Santander;

/**
 * Description of Carteira18
 *
 * @author italo
 */
class Carteira57 implements \Umbrella\Ya\Boleto\Carteira\CarteiraInterface
{

    public $tamanhos = array(
        'Banco' => 3,
        'Moeda' => 1,
        'FatorVencimento' => 4,
        'Valor' => 10,
        //Campos variávies
        'Agencia' => 4,
        'Conta' => 7,
        'NossoNumero' => 13,
        'Carteira' => 2,
    );
    protected $layout = ':Banco:Moeda:FatorVencimento:Valor:Agencia:Conta:DigitaoCobranca:NossoNumero';
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

    public function getTamanhos()
    {
        return $this->tamanhos;
    }

    public function getNumero()
    {
        return "57";
    }

}
