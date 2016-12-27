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

namespace Umbrella\YaBoleto\Type;

/**
 * Classe para manipulação de números.
 *
 * @author  Italo Lelis <italolelis@gmail.com>
 * @package YaBoleto
 */
class Number
{
    /**
     * Retorna um número formatado.
     *
     * @param  integer $number
     * @return integer
     */
    public static function format($number)
    {
        return (int)($number * 100);
    }

    /**
     * Calcula o módulo 11.
     *
     * O modulo 11, de um número é calculado multiplicando cada algarismo, pela seqüência de multiplicadores 2,3,4,5,6,7,8,9,2,3, ... posicionados da direita para a esquerda.
     * A soma dos algarismos do produto é dividida por 11 e o DV (dígito verificador) será a diferença entre o divisor ( 11 ) e o resto da divisão:
     * DV = 11 - (resto da divisão)
     * Observação: quando o resto da divisão for 0 (zero) ou 10 (dez), o DV calculado é o 0 (zero).
     *
     * EXEMPLO
     * calcular o DV módulo 11 da seguinte seqüência de números: 018 520 0005
     * A fórmula do cálculo é:
     * 1. Multiplicação pela seqüência 2,3,4,5,6,7,8,9,2,3, ... da direita para a esquerda.
     * 2. Soma dos dígitos do produto
     * 0 + 2 + 72 + 40 + 14 + 0 + 0 + 0 + 0 + 10 = 138
     *
     * Observação:
     * Neste caso os resultados deverão ser somados integralmente.
     *
     * 3. Divisão do resultado da soma acima por 11
     * 138 : 11 = 12 e o resto da divisão = 6
     * DV = 11 - (resto da divisão), portando 11 - 6 = 5
     *
     * @param  integer $number
     * @param  string $ifTen
     * @param  string $ifZero
     * @param  boolean $returnFull
     * @param  integer $maxFactor
     * @param  string $separator
     * @return string
     */
    public static function modulo11(
        $number,
        $ifTen = '0',
        $ifZero = '0',
        $returnFull = false,
        $maxFactor = 9,
        $separator = '-'
    ) {
        $numRev = strrev($number);
        $sum = 0;
        $factor = 2;
        $i  = 0;

        while($i <= strlen($numRev)-1){
            $sum += ($numRev{$i} * $factor);
            $factor = $factor >= $maxFactor? 2:($factor+1);
            $i++;
        }

        #Resto da divisão
        $rest = in_array(($sum % 11), ['0','10'])?'0':11 - ($sum % 11);


        if ($returnFull === false) {
            return $rest;
        } else {
            return $number . $separator . $rest;
        }
    }

    /**
     * Calcula o módulo 10.
     *
     * @param  string $num
     * @return integer
     */
    public static function modulo10($num)
    {
        $numtotal10 = 0;
        $fator = 2;
        $numeros = array();
        $parcial10 = array();

        // Separacao dos numeros
        for ($i = strlen($num); $i > 0; $i--) {
            // pega cada numero isoladamente
            $numeros[$i] = substr($num, $i - 1, 1);
            // Efetua multiplicacao do numero pelo (falor 10)
            // 2002-07-07 01:33:34 Macete para adequar ao Mod10 do Itau
            $temp = $numeros[$i] * $fator;
            $temp0 = 0;
            foreach (preg_split('//', $temp, -1, PREG_SPLIT_NO_EMPTY) as $k => $v) {
                $temp0 += $v;
            }
            $parcial10[$i] = $temp0;
            // monta sequencia para soma dos digitos no (modulo 10)
            $numtotal10 += $parcial10[$i];
            if ($fator == 2) {
                $fator = 1;
            } else {
                $fator = 2; // intercala fator de multiplicacao (modulo 10)
            }
        }

        // varias linhas removidas, vide funcoes original
        // Calculo do modulo 10
        $resto = $numtotal10 % 10;
        $digito = 10 - $resto;
        if ($resto == 0) {
            $digito = 0;
        }

        return $digito;
    }

    /**
     * Calcula o fator vencimento.
     *
     * @param  \DateTime $data
     * @return integer
     */
    public static function fatorVencimento(\DateTime $data)
    {
        $dataBase = new \DateTime("1997-10-07");

        return (int)$data->diff($dataBase, true)->format('%r%a');
    }

    /**
     * Calcula o primeiro dígito verificador da chave asbace
     *
     * @author Victor Felix <victor.dreed@gmail.com>
     * @param $chaveAsbace
     * @return int
     */
    public static function primeiroDvAsbace($chaveAsbace)
    {
        $peso = 1;
        $soma = 0;

        //Separação dos números
        for ($i = 0; $i < strlen($chaveAsbace); $i++) {
            //Isolando cada dígito
            $digito = substr($chaveAsbace, $i, 1);

            if (2 == $peso) {
                $peso--;
            } else {
                $peso++;
            }

            //Efetua multiplicação do dígito pelo peso
            $produto = (int) $digito * $peso;

            //Se o resultado da multiplicação for maior que 9
            //o produto recebe o da subtração dele mesmo menos 9.
            //Caso contrário, o produto continua com o valor
            //do resultado da multiplicação.
            $produto = 9 < $produto ? $produto - 9 : $produto;

            //Realiza a soma de todos os produtos
            $soma += $produto;
        }

        //Recupera o resto da divisão do resultado da soma por 10
        $resto = $soma % 10;

        return $resto == 0 ? 0 : 10 - $resto;
    }

    /**
     * Calcula o segundo dígito verificador da chave asbace
     *
     * @author Victor Felix <victor.dreed@gmail.com>
     * @param $chaveAsbace
     * @param $primeiroDv
     * @return int
     */
    public static function segundoDvAsbace($chaveAsbace, $primeiroDv)
    {
        $peso = 8;
        $soma = 0;
        $chaveComPrimeiroDv = $chaveAsbace . $primeiroDv;

        //Separação dos números
        for ($i = 0; $i < strlen($chaveComPrimeiroDv); $i++) {
            //Isolando cada dígito
            $digito = substr($chaveComPrimeiroDv, $i, 1);

            if (2 == $peso) {
                $peso = 7;
            } else {
                $peso--;
            }

            //Efetua multiplicação do dígito pelo peso e soma os resultados
            $soma += (int) $digito * $peso;
        }

        //Recupera o resto da divisão do resultado da soma por 11
        $resto = $soma % 11;

        if (0 == $resto) {
            return 0;
        } elseif (1 == $resto) {
            return 9 > $primeiroDv
                ? self::segundoDvAsbace($chaveAsbace, $primeiroDv + 1)
                : self::segundoDvAsbace($chaveAsbace, 0);
        }

        return 11 - $resto;
    }
}
