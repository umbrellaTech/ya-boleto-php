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
 * Clase que representa uma pessoa juridica
 * @author italo <italolelis@lellysinformatica.com>
 * @since 1.0.0
 */
class PessoaFisica extends Pessoa
{

    protected $cpf;

    /**
     * Inicializa uma nova instancia da classe PessoaFisica.
     * @param string $nome
     * @param string $cpf
     */
    public function __construct($nome, $cpf)
    {
        parent::__construct($nome);
        $this->setCpf($cpf);
    }

    /**
     * Retorna o cpf da pessoa fisica
     * @return string
     */
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * Define o cpf da pessoa fisica
     * @param string $cpf
     * @return \Umbrella\YA\Boleto\PessoaFisica
     */
    public function setCpf($cpf)
    {
        if (!Validator::cpf($cpf)) {
            throw new \InvalidArgumentException("O CPF informado e invalido");
        }
        $this->cpf = $cpf;
        return $this;
    }

}
