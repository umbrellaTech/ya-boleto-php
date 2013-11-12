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

namespace Umbrella\Ya\Boleto\View\Helper;

/**
 * Description of String
 *
 * @author italo
 */
class BarcodeCss implements BracodeRenderInterface
{

    public function render($codigoBarras)
    {
        $barcodes = array('00110', '10001', '01001', '11000', '00101', '10100', '01100', '00011', '10010', '01010');

        for ($f1 = 9; $f1 >= 0; $f1--) {
            for ($f2 = 9; $f2 >= 0; $f2--) {

                $f = ($f1 * 10) + $f2;
                $texto = '';

                for ($i = 1; $i < 6; $i++) {
                    $texto .= substr($barcodes[$f1], ($i - 1), 1) . substr($barcodes[$f2], ($i - 1), 1);
                }

                $barcodes[$f] = $texto;
            }
        }

        // Guarda inicial
        $retorno = '<div class="barcode">' .
                '<div class="black thin"></div>' .
                '<div class="white thin"></div>' .
                '<div class="black thin"></div>' .
                '<div class="white thin"></div>';

        if (strlen($codigoBarras) % 2 != 0) {
            $codigoBarras = "0" . $codigoBarras;
        }

        // Draw dos dados
        while (strlen($codigoBarras) > 0) {

            $i = (int) round($this->caracteresEsquerda($codigoBarras, 2));
            $codigoBarras = $this->caracteresDireita($codigoBarras, strlen($codigoBarras) - 2);
            $f = $barcodes[$i];

            for ($i = 1; $i < 11; $i += 2) {

                if (substr($f, ($i - 1), 1) == "0") {
                    $f1 = 'thin';
                } else {
                    $f1 = 'large';
                }

                $retorno .= "<div class='black {$f1}'></div>";

                if (substr($f, $i, 1) == "0") {
                    $f2 = 'thin';
                } else {
                    $f2 = 'large';
                }

                $retorno .= "<div class='white {$f2}'></div>";
            }
        }

        // Final
        return $retorno . '<div class="black large"></div>' .
                '<div class="white thin"></div>' .
                '<div class="black thin"></div>' .
                '</div>';
    }

    /**
     * Helper para obter os caracteres à esquerda
     *
     * @param string $string
     * @param int $num Quantidade de caracteres para se obter
     * @return string
     */
    protected function caracteresEsquerda($string, $num)
    {
        return substr($string, 0, $num);
    }

    /**
     * Helper para se obter os caracteres à direita
     *
     * @param string $string
     * @param int $num Quantidade de caracteres para se obter
     * @return string
     */
    protected function caracteresDireita($string, $num)
    {
        return substr($string, strlen($string) - $num, $num);
    }

}
