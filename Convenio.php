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
class Convenio
{

    /**
     * @var Banco 
     */
    protected $banco;

    /**
     * @var Carteira\CarteiraInterface 
     */
    protected $carteira;
    protected $convenio;

    public function __construct(Banco $banco, Carteira\CarteiraInterface $carteira, $convenio)
    {
        $this->banco = $banco;
        $this->carteira = $carteira;
        $this->convenio = $convenio;
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
     * @return \Umbrella\Ya\Boleto\Convenio
     */
    public function setBanco(Banco $banco)
    {
        $this->banco = $banco;
        return $this;
    }

    /**
     * Retorna a carteira do convenio
     * @return Carteira\CarteiraInterface
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
     * @param Carteira\CarteiraInterface $carteira
     * @return \Umbrella\Ya\Boleto\Convenio
     */
    public function setCarteira($carteira)
    {
        $this->carteira = $carteira;
        return $this;
    }

    /**
     * Define o numero do convenio
     * @param string $convenio
     * @return \Umbrella\Ya\Boleto\Convenio
     */
    public function setConvenio($convenio)
    {
        $this->convenio = $convenio;
        return $this;
    }

}
