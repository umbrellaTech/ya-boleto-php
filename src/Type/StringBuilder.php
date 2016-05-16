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
 * Classe para manipulação de strings.
 *
 * @author  Italo Lelis <italolelis@lellysinformatica.com>
 * @package YaBoleto
 */
class StringBuilder
{

    /**
     * [putAt description]
     *
     * @param  string $text
     * @param  string $put
     * @param  integer $at
     * @return string
     */
    public static function putAt($text, $put, $at)
    {
        return self::left($text, $at) . $put . mb_substr($text, $at);
    }

    /**
     * [left description]
     *
     * @param  string $text
     * @param  integer $length
     * @return string
     */
    public static function left($text, $length)
    {
        return mb_substr($text, 0, $length);
    }

    /**
     * [applyMask description]
     *
     * @param  string $text
     * @param  string $mask
     * @return string
     */
    public static function applyMask($text, $mask)
    {
        $length = strlen($text);
        $buff = '';

        $special = array('/', '.', '-', '_', ' ');

        for ($i = 0, $j = 0; $i < $length; $i++, $j++) {
            if (!isset($text[$i]) || !isset($mask[$j])) {
                break;
            }

            if (in_array($mask[$j], $special)) {
                $buff .= $mask[$j];
                $j++;
            }

            $buff .= $text[$i];
        }

        return $buff;
    }

    /**
     * Completa com zeros adicionais à esquerda até o valor informado.
     *
     * @param  string $text
     * @param  string $length
     * @return string
     */
    public static function zeros($text, $length)
    {
        return str_pad($text, $length, '0', STR_PAD_LEFT);
    }

    /**
     * Completa com zeros adicionais à esquerda até o valor informado,
     * alterando a variável original, e cortando caso o valor tenha
     * mais caracteres que o permitido.
     *
     * @param  string $var
     * @param  string $length
     * @return string
     */
    public static function normalize(&$var, $length)
    {
        return self::left(self::zeros($var, $length), $length);
    }

    /**
     * [insert description]
     *
     * @param  string $string
     * @param  \ArrayObject $data
     * @return string
     */
    public static function insert($string, $data)
    {
        foreach ($data as $key => $value):
            $regex = '%(:' . $key . ')%';
            $string = preg_replace($regex, $value, $string);
        endforeach;

        return $string;
    }

}
