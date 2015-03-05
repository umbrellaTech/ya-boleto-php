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
 * Classe abstrata que representa uma Pessoa
 * 
 * @author Ian Rodrigues <me@ianrodrigu.es>
 * @since 1.5.1
 */
abstract class Pessoa
{

    protected $nome;
    protected $endereco;
    protected $cep;
    protected $cidade;
    protected $uf;

    /**
     * @param string $nome
     */
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
     * 
     * @param  string   $nome
     * @return \Umbrella\Ya\Boleto\Pessoa
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Retorna o endereço formatado
     * 
     * @return string
     */
    public function getEndereco()
    {
        return $this->endereco.' - '.$cep.' - '.$cidade.'/'.$uf;;
    }

    /**
     * Define o endereço da pessoa
     * 
     * @param string $endereco
     * @param string $cep
     * @param string $cidade
     * @param string $uf
     * @return \Umbrella\Ya\Boleto\Pessoa
     */
    public function setEndereco($endereco, $cep, $cidade, $uf)
    {
        $this->endereco = $endereco;
        $this->cep      = $cep;
        $this->cidade   = $cidade;
        $this->estado   = $estado;

        return $this;
    }

}
