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
 * Classe abstrata que representa uma pessoa, física ou jurídica.
 *
 * @author  Ian Rodrigues <me@ianrodrigu.es>
 * @package YaBoleto
 */
abstract class Pessoa
{
    /**
     * @var string Nome/Razão Social da pessoa
     */
    protected $nome;

    /**
     * @var Endereco
     */
    protected $endereco;

    /**
     * Inicializa uma nova instância da classe.
     *
     * @param string $nome Nome da Nome/Razão Social da pessoa
     * @param Endereco $endereco
     */
    public function __construct($nome, Endereco $endereco)
    {
        $this->nome = $nome;
        $this->endereco = $endereco;
    }

    /**
     * Retorna o nome da pessoa.
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }
    
    /**
     * @return Endereco
     */
    public function getEndereco()
    {
        return $this->endereco;
    }
}
