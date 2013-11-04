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

namespace Umbrella\YA\Boleto;

/**
 * Clase abstrata que representa uma Pessoa
 * @author italo <italolelis@lellysinformatica.com>
 * @since 1.0.0
 */
abstract class Pessoa
{

    protected $nome;

    public function __construct($nome)
    {
        $this->nome = $nome;
    }

    /**
     * Retorna o nome da pessoa
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Define o nome da pessoa
     * @param string $nome
     * @return \Umbrella\YA\Boleto\Pessoa
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

}
