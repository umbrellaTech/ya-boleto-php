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

namespace Umbrella\YaBoleto\Bancos\Bradesco\Boleto;

use Umbrella\YaBoleto\AbstractBoleto;

/**
 * Classe que representa o boleto do Bradesco.
 *
 * @author  Italo Lelis <italolelis@gmail.com>
 * @package YaBoleto
 */
class Bradesco extends AbstractBoleto
{

    /**
     * Retorna a conta formatada
     *
     * @return string
     */
    protected function getContaFormatada()
    {
        return substr($this->convenio->getBanco()->getConta(), 0, 5);
    }

    /**
     * Gera a linha digitável baseado em um código de barras.
     *
     * @param  string $codigoBarras
     * @return string
     */
    protected function gerarLinhaDigitavel($codigoBarras)
    {
        if ($this->getConvenio()->getCarteira() instanceof Carteira09) {
            return parent::gerarLinhaDigitavel($codigoBarras);
        }

        // Campo1 - Posições de 1-5
        $linhaDigitavel = substr($codigoBarras, 0, 4) . substr($codigoBarras, 19, 5)
            // Campo2 - Posições 26-35
            . substr($codigoBarras, 25, 10)
            // Campo3 - Posições 36-44
            . substr($codigoBarras, 35, 9)
            // Campo4 - Posição 5
            . substr($codigoBarras, 4, 1)
            // Campo5 - Posições 6-19
            . substr($codigoBarras, 5, 14);

        $dv1 = Number::modulo10(substr($linhaDigitavel, 0, 9));
        $dv2 = Number::modulo10(substr($linhaDigitavel, 9, 10));
        $dv3 = Number::modulo10(substr($linhaDigitavel, 19, 10));

        $linhaDigitavel = StringBuilder::putAt($linhaDigitavel, $dv3, 31);
        $linhaDigitavel = StringBuilder::putAt($linhaDigitavel, $dv2, 20);
        $linhaDigitavel = StringBuilder::putAt($linhaDigitavel, $dv1, 9);

        return StringBuilder::applyMask($linhaDigitavel, $this->mascara);
    }

}
