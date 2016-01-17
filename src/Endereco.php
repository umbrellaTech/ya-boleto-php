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

class Endereco
{
    /** @var string Logradouro da pessoa - ex.: 'Rua das Oliveiras, 10 - Sala 301' */
    protected $logradouro;
    /** @var string CEP do endereço da pessoa */
    protected $cep;
    /** @var string Cidade da pessoa */
    protected $cidade;
    /** @var string Estado da pessoa */
    protected $uf;

    /**
     * Endereco constructor.
     * @param string $logradouro
     * @param string $cep
     * @param string $cidade
     * @param string $uf
     */
    public function __construct($logradouro, $cep, $cidade, $uf)
    {
        $this->logradouro = $logradouro;
        $this->cep = $cep;
        $this->cidade = $cidade;
        $this->uf = $uf;
    }

    /**
     * @return string
     */
    public function getLogradouro()
    {
        return $this->logradouro;
    }

    /**
     * @return string
     */
    public function getCep()
    {
        return $this->cep;
    }

    /**
     * @return string
     */
    public function getCidade()
    {
        return $this->cidade;
    }

    /**
     * @return string
     */
    public function getUf()
    {
        return $this->uf;
    }
}

