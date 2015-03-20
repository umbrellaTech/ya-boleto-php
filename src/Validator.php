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

namespace Umbrella\YaBoleto;

/**
 * Classe para validação de campos.
 * 
 * @author  Italo Lelis <italolelis@lellysinformatica.com>
 * @package YaBoleto
 */
class Validator
{
    /**
     * Valida um CPF verificando seus algarismos e seus dígitos verificadores. 
     * Para fins de validação, cpf() não leva em consideração as presenças de pontos e 
     * traços ao número informado.
     *                       
     * @param  string $cpf
     * @return boolean
     */
    public static function cpf($cpf)
    {
        $cpf = sprintf('%011s', preg_replace('{\D}', '', $cpf));

        if ((strlen($cpf) != 11) || ($cpf == '00000000000') || ($cpf == '99999999999')) {
            return false;
        }

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
     * Valida um CNPJ verificando seus algarismos e seus dígitos verificadores. 
     * Para fins de validação, cnpj() não leva em consideração as presenças de pontos e 
     * traços ao número informado.
     *                       
     * @param  string $cnpj
     * @return boolean
     */
    public static function cnpj($cnpj)
    {
        $cnpj = sprintf('%014s', preg_replace('{\D}', '', $cnpj));

        if ((strlen($cnpj) != 14) || (intval(substr($cnpj, -4)) == 0)) {
            return false;
        }

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
