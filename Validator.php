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

namespace Umbrella\YA\Boleto;

/**
 * Description of Validator
 *
 * @author italo
 */
class Validator
{

    /**
     * Valida um CPF verificando seus algarismos e seus dígitos verificadores. 
     * Para fins de validação, cpf() não leva em consideração as presenças de pontos e 
     * traços ao número informado.
     *                       
     * @param $value CPF a ser verificado
     * @return boolean
     */
    public static function cpf($cpf)
    {   
        // Canonicalize input
        $cpf = sprintf('%011s', preg_replace('{\D}', '', $cpf));

        // Validate length and invalid numbers
        if ((strlen($cpf) != 11) || ($cpf == '00000000000') || ($cpf == '99999999999')) {
            return false;
        }

        // Validate check digits using a modulus 11 algorithm
        for ($t = 8; $t < 10;) {
            for ($d = 0, $p = 2, $c = $t; $c >= 0; $c--, $p++) {
                $d += $cpf[$c] * $p;
            }

            if ($cpf[++$t] != ($d = ((10 * $d) % 11) % 10)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Valida um CNPJ.
     * cnpj() não considera pontos, traços e barras.
     * 
     * @param $cnpj CNPJ a ser verificado
     * @return boolean
     */
    public static function cnpj($cnpj)
    {
        // Canonicalize input
        $cnpj = sprintf('%014s', preg_replace('{\D}', '', $cnpj));

        // Validate length and CNPJ order
        if ((strlen($cnpj) != 14) || (intval(substr($cnpj, -4)) == 0)) {
            return false;
        }

        // Validate check digits using a modulus 11 algorithm
        for ($t = 11; $t < 13;) {
            for ($d = 0, $p = 2, $c = $t; $c >= 0; $c--, ($p < 9) ? $p++ : $p = 2) {
                $d += $cnpj[$c] * $p;
            }

            if ($cnpj[++$t] != ($d = ((10 * $d) % 11) % 10)) {
                return false;
            }
        }

        return true;
    }

}
