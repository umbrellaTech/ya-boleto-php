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
    /** @var string Nome/Razão Social da pessoa */
    protected $nome;
    /** @var string Logradouro da pessoa - ex.: 'Rua das Oliveiras, 10 - Sala 301' */
    protected $logradouro;
    /** @var string CEP do endereço da pessoa */
    protected $cep;
    /** @var string Cidade da pessoa */
    protected $cidade;
    /** @var string Estado da pessoa */
    protected $uf;

    /**
     * Inicializa uma nova instância da classe.
     * 
     * @param string $nome             Nome da Nome/Razão Social da pessoa
     * @param array  $enderecoCompleto Endereço da pessoa - array('logradouro' => '', 'cep' => '', 'cidade' => '', 'uf' => '')
     */
    public function __construct($nome, array $enderecoCompleto)
    {
        $this->nome = $nome;
        foreach ($enderecoCompleto as $key => $value) {
            $this->$key = $value;
        }
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
     * Define o nome da pessoa.
     * 
     * @param  string   $nome
     * @return \Umbrella\YaBoleto\Pessoa
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Retorna o endereço formatado da pessoa.
     * 
     * @return string
     */
    public function getEndereco()
    {
        return sprintf('%s - %s - %s/%s', $this->logradouro, $this->cep, $this->cidade, $this->uf);
    }

    /**
     * Define o endereço completo da pessoa.
     * 
     * @param string $logradouro Logradouro da pessoa - ex.: 'Rua das Oliveiras, 10 - Sala 301'
     * @param string $cep        CEP do endereço da pessoa
     * @param string $cidade     Cidade da pessoa
     * @param string $uf         UF da pessoa
     * @return \Umbrella\YaBoleto\Pessoa
     */
    public function setEndereco($logradouro, $cep, $cidade, $uf)
    {
        $this->logradouro = $logradouro;
        $this->cep        = $cep;
        $this->cidade     = $cidade;
        $this->uf         = $uf;

        return $this;
    }

}
