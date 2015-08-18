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

use ArrayObject;
use Umbrella\YaBoleto\Type\Number;

/**
 * Classe abstrata que representa o convênio.
 * 
 * @author  Italo Lelis <italolelis@lellysinformatica.com>
 * @package YaBoleto
 */
abstract class AbstractConvenio implements ConvenioInterface
{
    /** @var \Umbrella\YaBoleto\AbstractBanco */
    protected $banco;
    /** @var \Umbrella\YaBoleto\CarteiraInterface */
    protected $carteira;
    /** @var string Número do convênio */
    protected $convenio;
    /** @var string Nosso número */
    protected $nossoNumero;
    /** @var string Dígito verificador do nosso número */
    protected $dvNossoNumero;
    /** @var string Layout do código de barras */
    protected $layout;
    
    /** @var array Tamanho de alguns campos do código de barras */
    public $tamanhos = array(
        'Banco'           => 3,
        'Moeda'           => 1,
        'DV'              => 1,
        'FatorVencimento' => 4,
        'Valor'           => 10,
        'Agencia'         => 4,
        'Conta'           => 8,
        'Carteira'        => 2
    );

    /**
     * Inicializa uma nova instância da classe.
     *
     * @param \Umbrella\YaBoleto\AbstractAbstractBanco $banco        Banco emissor
     * @param \Umbrella\YaBoleto\CarteiraInterface $carteira Carteira do boleto
     * @param sting  $convenio                               Número do convênio
     * @param string $nossoNumero                            Nosso número do boleto
     */
    public function __construct(AbstractBanco $banco, CarteiraInterface $carteira, $convenio, $nossoNumero)
    {
        $this->banco       = $banco;
        $this->carteira    = $carteira;
        $this->convenio    = $convenio;
        $this->nossoNumero = $nossoNumero;
    }

    /**
     * Gera o campo livre do código de barras.
     * 
     * @param  ArrayObject $data
     * @return $data
     */
    abstract public function gerarCampoLivre(ArrayObject $data);

    /**
     * Ajusta o nosso número antes de setar o mesmo.
     *
     * @param ArrayObject $data
     * @return string
     */
    public function ajustarNossoNumero(ArrayObject $data)
    {
        return $data['NossoNumero'];
    }

    /**
     * Seta o layout do código de barras.
     *
     * @param string $layout
     * @return \Umbrella\YaBoleto\AbstractConvenio $this
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;

        return $this;
    }

    /**
     * Seta o nosso número.
     *
     * @param string $nossoNumero
     * @return \Umbrella\YaBoleto\AbstractConvenio $this
     */
    public function setNossoNumero($nossoNumero)
    {
        // seta o dígito verificador do nosso número...
        $this->setDvNossoNumero($this->carteira->getNumero(), $nossoNumero);

        $this->nossoNumero = $nossoNumero;

        return $this;
    }

    /**
     * Seta o dígito verificador do nosso número.
     *
     * @param string $carteira
     * @param string $nossoNumero
     * @param string $ifTen
     * @param string $ifZero
     * @return \Umbrella\YaBoleto\AbstractConvenio $this
     */
    public function setDvNossoNumero($carteira, $nossoNumero, $ifTen = 'P', $ifZero = '0')
    {
        $this->dvNossoNumero = Number::modulo11($carteira.$nossoNumero, $ifTen, $ifZero, false, 7);

        return $this;
    }

    /**
     * Define o número do convênio.
     * 
     * @param  string $convenio
     * @return \Umbrella\YaBoleto\AbstractConvenio $this
     */
    public function setConvenio($convenio)
    {
        $this->convenio = $convenio;

        return $this;
    }

    /**
     * Altera o tamanho de um campo do código de barras.
     * 
     * @param  string $index
     * @param  integer $tamanho
     */
    public function alterarTamanho($index, $tamanho)
    {
        $this->tamanhos[$index] = $tamanho;
    }

    /**
     * Retorna o layout do código de barras
     * 
     * @return string
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * Retorna o nosso número
     * 
     * @return string
     */
    public function getNossoNumero()
    {
        return $this->nossoNumero;
    }

    /**
     * Retorna o dígito verificador do nosso número
     * 
     * @return string
     */
    public function getDvNossoNumero()
    {
        return $this->dvNossoNumero;
    }

    /**
     * Retorna o banco do convênio.
     * 
     * @return \Umbrella\YaBoleto\AbstractBanco
     */
    public function getBanco()
    {
        return $this->banco;
    }

    /**
     * Retorna a carteira do convênio.
     * 
     * @return \Umbrella\YaBoleto\CarteiraInterface
     */
    public function getCarteira()
    {
        return $this->carteira;
    }

    /**
     * Retorna o número do convênio.
     * 
     * @return string
     */
    public function getConvenio()
    {
        return $this->convenio;
    }

    /**
     * Retorna os tamanhos dos campos do código de barras.
     * 
     * @return array
     */
    public function getTamanhos()
    {
        return $this->tamanhos;
    }

}
