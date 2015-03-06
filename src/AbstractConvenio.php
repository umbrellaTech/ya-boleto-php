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

use ArrayObject;
use Umbrella\Ya\Boleto\Carteira\CarteiraInterface;

/**
 * Clase abstrata que representa o Convenio
 * @author italo <italolelis@lellysinformatica.com>
 * @since 1.0.0
 */
abstract class AbstractConvenio implements ConvenioInterface
{
    /**
     * @var Banco
     */
    protected $banco;

    /**
     * @var CarteiraInterface
     */
    protected $carteira;
    protected $convenio;
    protected $nossoNumero;
    protected $dvNossoNumero;
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

    /**
     * @param string $convenio
     * @param string $nossoNumero
     */
    public function __construct(Banco $banco, CarteiraInterface $carteira, $convenio, $nossoNumero)
    {
        $this->banco = $banco;
        $this->carteira = $carteira;
        $this->convenio = $convenio;
        $this->nossoNumero = $nossoNumero;
    }

    abstract public function gerarCampoLivre(ArrayObject $data);

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
     * @param  Banco            $banco
     * @return AbstractConvenio
     */
    public function setBanco(Banco $banco)
    {
        $this->banco = $banco;

        return $this;
    }

    /**
     * Retorna a carteira do convenio
     * @return CarteiraInterface
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
     * @param  CarteiraInterface                   $carteira
     * @return AbstractConvenio
     */
    public function setCarteira($carteira)
    {
        $this->carteira = $carteira;

        return $this;
    }

    /**
     * Define o numero do convenio
     * @param  string                               $convenio
     * @return AbstractConvenio
     */
    public function setConvenio($convenio)
    {
        $this->convenio = $convenio;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function alterarTamanho($index, $tamanho)
    {
        $this->tamanhos[$index] = $tamanho;
    }

    /**
     * {@inheritdoc}
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * {@inheritdoc}
     */
    public function getNossoNumero()
    {
        return $this->nossoNumero;
    }

    /**
     * {@inheritdoc}
     */
    public function getDvNossoNumero()
    {
        return $this->dvNossoNumero;
    }

    /**
     * {@inheritdoc}
     */
    public function getTamanhos()
    {
        return $this->tamanhos;
    }

    /**
     * {@inheritdoc}
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setDvNossoNumero($carteira, $nossoNumero, $ifTen = 'P', $ifZero = '0')
    {
        $this->dvNossoNumero = Type\Number::modulo11($carteira.$nossoNumero, $ifTen, $ifZero, false, 7);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setNossoNumero($nossoNumero)
    {
        /** Seta o DV do Nosso Número */
        $this->setDvNossoNumero($this->carteira->getNumero(), $nossoNumero);

        $this->nossoNumero = $nossoNumero;

        return $this;
    }
}
