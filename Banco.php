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
 * Clase abstrata que representa o Banco. Os dados da classe foram retirados da FEBRABAN
 * @author italo <italolelis@lellysinformatica.com>
 * @since 1.0.0
 */
abstract class Banco
{

    protected $codigo;
    protected $numero;
    protected $agencia;
    protected $conta;
    protected $nome;

    public function __construct($numero, $nome, $agencia, $conta)
    {
        $this->numero = $numero;
        $this->nome = $nome;
        $this->agencia = $agencia;
        $this->conta = $conta;
        $this->codigo = Type\Number::modulo11($this->numero);
    }

    public function getCodigo()
    {
        return $this->codigo;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
        return $this;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    /**
     * Retorna o numero do banco
     * @return int
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Rotorna o numero da agencia
     * @return string
     */
    public function getAgencia()
    {
        return $this->agencia;
    }

    /**
     * Retorna o numero da conta
     * @return string
     */
    public function getConta()
    {
        return $this->conta;
    }

    /**
     * Define o numero do banco
     * @param int $numero
     * @return \Umbrella\YA\Boleto\Banco
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
        return $this;
    }

    /**
     * Define o numero da agencia
     * @param string $agencia
     * @return \Umbrella\YA\Boleto\Banco
     */
    public function setAgencia($agencia)
    {
        $this->agencia = $agencia;
        return $this;
    }

    /**
     * Define o numero da conta
     * @param setring $conta
     * @return \Umbrella\YA\Boleto\Banco
     */
    public function setConta($conta)
    {
        $this->conta = $conta;
        return $this;
    }

    public function getAgenciaConta()
    {
        return $this->getAgencia() . '/' . $this->getConta();
    }

}
