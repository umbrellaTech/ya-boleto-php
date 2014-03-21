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

namespace Umbrella\Ya\Boleto;

/**
 * Clase que representa um Sacado
 * @author italo <italolelis@lellysinformatica.com>
 * @since 1.0.0
 */
class Sacado
{

    /**
     * @var Pessoa
     */
    protected $tipo;

    public function __construct(Pessoa $tipo)
    {
        $this->tipo = $tipo;
    }

    /**
     * Retorna o tipo da pessoa para o sacado
     * @return Pessoa
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Define o tipo da pessoa para o sacado
     * @param  \Umbrella\Ya\Boleto\Pessoa $tipo
     * @return \Umbrella\Ya\Boleto\Sacado
     */
    public function setTipo(Pessoa $tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

}
