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

use Umbrella\YaBoleto\Type\Number;

/**
 * Classe abstrata que representa um banco.
 * 
 * @author  Italo Lelis <italolelis@gmail.com>
 * @package YaBoleto
 */
abstract class AbstractBanco
{
    /** @var integer */
    protected $codigo;
    /** @var string */
    protected $numero;
    /** @var string */
    protected $agencia;
    /** @var string */
    protected $conta;
    /** @var string */
    protected $nome;

    /**
     * Inicializa uma nova instância da classe.
     * 
     * @param string $numero  Número do banco
     * @param string $nome    Nome do banco
     * @param string $agencia Agência favorecida
     * @param string $conta   Conta favorecida
     */
    public function __construct($numero, $nome, $agencia, $conta)
    {
        $this->numero = $numero;
        $this->nome = $nome;
        $this->agencia = $agencia;
        $this->conta = $conta;
        $this->codigo = Number::modulo11($this->numero);
    }

    /**
     * Retorna o numero do banco.
     * 
     * @return integer
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Retorna o nome do banco.
     * 
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Rotorna o número da agência favorecida.
     * 
     * @return string
     */
    public function getAgencia()
    {
        return $this->agencia;
    }

    /**
     * Retorna o número da conta favorecida.
     * 
     * @return string
     */
    public function getConta()
    {
        return $this->conta;
    }

    /**
     * Retorna o código do banco.
     * 
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

}
