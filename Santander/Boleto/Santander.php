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

namespace Umbrella\Ya\Boleto\Santander\Boleto;

use Umbrella\Ya\Boleto\Boleto;

/**
 * Clase abstrata que representa o Boleto do Banco do Brasil
 * @author italo <italolelis@lellysinformatica.com>
 * @since 1.0.0
 */
class Santander extends Boleto
{

    protected function afterGeneration(&$cod)
    {
        //$this->dvBarra($cod);
    }

    private function dvBarra(&$numero)
    {
        $pesos = "43290876543298765432987654329876543298765432";
        if (strlen($numero) == 44) {
            $soma = 0;
            for ($i = 0; $i < strlen($numero); $i++) {
                $soma += $numero[$i] * $pesos[$i];
            } $num_temp = 11 - ($soma % 11);
            if ($num_temp >= 10) {
                $num_temp = 1;
            } $numero[4] = $num_temp;
        }
    }

}
