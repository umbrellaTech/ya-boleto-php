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
 * Classe que representa uma pessoa jurídica.
 *
 * @author  Italo Lelis <italolelis@gmail.com>
 * @package YaBoleto
 */
class PessoaJuridica extends Pessoa
{
    /**
     * @var Cnpj CNPJ da pessoa jurídica
     */
    protected $cnpj;

    /**
     * Inicializa uma nova instância da classe \Umbrella\YaBoleto\PessoaJuridica.
     *
     * @param string $nome Nome da Razão Social da pessoa jurídica
     * @param Cnpj $cnpj CNPJ da pessoa jurídica
     * @param Endereco $endereco
     */
    public function __construct($nome, Cnpj $cnpj, Endereco $endereco)
    {
        parent::__construct($nome, $endereco);
        $this->cnpj = $cnpj;
    }

    /**
     * Retorna o CNPJ da pessoa jurídica.
     *
     * @return Cnpj
     */
    public function getCnpj()
    {
        return $this->cnpj;
    }
}
