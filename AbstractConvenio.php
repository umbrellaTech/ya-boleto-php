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
 * Clase abstrata que representa o Convenio
 * @author italo <italolelis@lellysinformatica.com>
 * @since 1.0.0
 */
class AbstractConvenio implements IConvenio
{

    /**
     * @var Banco 
     */
    protected $banco;

    /**
     * @var Carteira\ICarteira 
     */
    protected $carteira;
    protected $convenio;
    protected $nossoNumero;
    protected $layout;
    public $tamanhos = array(
        'Banco' => 3,
        'Moeda' => 1,
        'DV' => 1,
        'FatorVencimento' => 4,
        'Valor' => 10,
        'Agencia' => 4,
        'Conta' => 8,
        'Carteira' => 2
    );

    public function __construct(Banco $banco, Carteira\ICarteira $carteira, $convenio, $nossoNumero)
    {
        $this->banco = $banco;
        $this->carteira = $carteira;
        $this->convenio = $convenio;
        $this->nossoNumero = $nossoNumero;
    }

    /**
     * Retorna o banco para o convenio
     * @return Banco
     */
    public function getBanco()
    {
        return $this->banco;
    }

    /**
     * Define o banco para o convenio
     * @param \Umbrella\Ya\Boleto\Banco $banco
     * @return \Umbrella\Ya\Boleto\AbstractConvenio
     */
    public function setBanco(Banco $banco)
    {
        $this->banco = $banco;
        return $this;
    }

    /**
     * Retorna a carteira do convenio
     * @return Carteira\ICarteira
     */
    public function getCarteira()
    {
        return $this->carteira;
    }

    /**
     * Retorna o numero do convenio
     * @return string
     */
    public function getConvenio()
    {
        return $this->convenio;
    }

    /**
     * Define a carteira do convenio
     * @param Carteira\ICarteira $carteira
     * @return \Umbrella\Ya\Boleto\AbstractConvenio
     */
    public function setCarteira($carteira)
    {
        $this->carteira = $carteira;
        return $this;
    }

    /**
     * Define o numero do convenio
     * @param string $convenio
     * @return \Umbrella\Ya\Boleto\AbstractConvenio
     */
    public function setConvenio($convenio)
    {
        $this->convenio = $convenio;
        return $this;
    }

    public function alterarTamanho($index, $tamanho)
    {
        $this->tamanhos[$index] = $tamanho;
    }

    public function getLayout()
    {
        return $this->layout;
    }

    public function getNossoNumero()
    {
        return $this->nossoNumero;
    }

    public function getTamanhos()
    {
        return $this->tamanhos;
    }

    public function setLayout($layout)
    {
        $this->layout = $layout;
        return $this;
    }

    public function setNossoNumero($nossoNumero)
    {
        $this->nossoNumero = $nossoNumero;
        return $this;
    }

}
