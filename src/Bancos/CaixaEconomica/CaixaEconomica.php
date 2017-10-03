<?php
/*
 * The MIT License
 *
 * Copyright 2013 italo.
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

namespace Umbrella\YaBoleto\Bancos\CaixaEconomica;

use Umbrella\YaBoleto\AbstractBanco;

/**
 * Classe que representa a Caixa Econômica.
 * 
 * @author  Edmo Farias <edmofarias@gmail.com>
 * @package YaBoleto
 */
class CaixaEconomica extends AbstractBanco
{
    /**
     * Inicializa uma nova instância da classe.
     * 
     * @param string $agencia Agência favorecida
     * @param string $conta   Conta favorecida
     */
    public function __construct($agencia, $conta)
    {
        $numero = '104';
        $nome   = 'Caixa Ecônomica Federal';
        parent::__construct($numero, $nome, $agencia, $conta);
    }

}
