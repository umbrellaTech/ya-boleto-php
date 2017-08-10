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

namespace Umbrella\YaBoleto\Bancos\CaixaEconomica\Carteira;

use Umbrella\YaBoleto\CarteiraInterface;

/**
 * Classe que representa a carteira Sigcb da Caixa Econômia.
 * 
 * @author  Edmo Farias <edmofarias@gmail.com>
 * @package YaBoleto
 */
class CarteiraSigcb implements CarteiraInterface
{
    private $tipo;

    /**
     * Inicializa uma nova instância da classe.
     * 
     * @param string $tipo Tipo da carteira
     */
    public function __construct($tipo = null)
    {
        $this->tipo = $tipo;
    }

    /**
     * Retorna o número do convênio.
     * 
     * @return string
     */
    public function getNumero()
    {
        if ($this->tipo) {
            return $this->tipo;
        }

        return "1";
    }
}
