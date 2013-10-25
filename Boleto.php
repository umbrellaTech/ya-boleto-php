<?php

/*
 * The MIT License
 *
 * Copyright 2013 UmbrellaTech.
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
 * Clase abstrata que representa o Boleto. Os dados da classe foram retirados da FEBRABAN
 * @author italo <italolelis@lellysinformatica.com>
 * @since 1.0.0
 */
abstract class Boleto
{

    /**
     *
     * @var Banco
     */
    protected $banco;
    protected $carteira;
    protected $nossoNumero;
    protected $convenio;
    protected $cendente;
    protected $sacado;
    protected $valorDocumento;
    protected $dataVencimento;
    protected $taxa;
    protected $numeroDocumento;
    protected $codigoBarras;
    protected $linhaDigitavel;

    /**
     * Cria uma nova instancia do Boleto
     * @param \Umbrella\YA\Boleto\Banco $banco Instancia do Banco para o boleto
     */
    public function __construct(Banco $banco)
    {
        $this->banco = $banco;
        $this->codigoBarras = $this->getCodigoBarras();
        $this->linhaDigitavel = $this->gerarLinhaDigitavel();
    }

    /**
     * Gera o codigo de barras, baseado nas informaoes do banco
     */
    protected abstract function gerarCodigoBarras();

    /**
     * Gera a linha digitavel do boleto
     */
    protected abstract function gerarLinhaDigitavel();

    /**
     * Retorna o numero da carteira
     * @return int
     */
    public function getCarteira()
    {
        return $this->carteira;
    }

    /**
     * Retorna o nosso numero
     * @return int
     */
    public function getNossoNumero()
    {
        return $this->nossoNumero;
    }

    /**
     * Retorna o convenio
     * @return int
     */
    public function getConvenio()
    {
        return $this->convenio;
    }

    /**
     * Retorna o valor da taxa do boleto
     * @return float
     */
    public function getTaxa()
    {
        return $this->taxa;
    }

    /**
     * Retorna o numero do documento
     * @return int
     */
    public function getNumeroDocumento()
    {
        return $this->numeroDocumento;
    }

    /**
     * Define o numero da carteira
     * @param int $carteira
     * @return \Umbrella\YA\Boleto\Boleto
     */
    public function setCarteira($carteira)
    {
        $this->carteira = $carteira;
        return $this;
    }

    /**
     * Define o nosso numero
     * @param int $nossoNumero
     * @return \Umbrella\YA\Boleto\Boleto
     */
    public function setNossoNumero($nossoNumero)
    {
        $this->nossoNumero = $nossoNumero;
        return $this;
    }

    /**
     * Define o convenio
     * @param int $convenio
     * @return \Umbrella\YA\Boleto\Boleto
     */
    public function setConvenio($convenio)
    {
        $this->convenio = $convenio;
        return $this;
    }

    /**
     * Define a taxa do boleto
     * @param float $taxa
     * @return \Umbrella\YA\Boleto\Boleto
     */
    public function setTaxa($taxa)
    {
        $this->taxa = $taxa;
        return $this;
    }

    /**
     * Define o numero do documento
     * @param int $numeroDocumento
     * @return \Umbrella\YA\Boleto\Boleto
     */
    public function setNumeroDocumento($numeroDocumento)
    {
        $this->numeroDocumento = $numeroDocumento;
        return $this;
    }

    /**
     * Retorna o cedente
     * @return string
     */
    public function getCendente()
    {
        return $this->cendente;
    }

    /**
     * Retorna o sacado
     * @return string
     */
    public function getSacado()
    {
        return $this->sacado;
    }

    /**
     * Define o cedente
     * @param string $cendente
     * @return \Umbrella\YA\Boleto\Boleto
     */
    public function setCendente($cendente)
    {
        $this->cendente = $cendente;
        return $this;
    }

    /**
     * Define o sacado
     * @param string $sacado
     * @return \Umbrella\YA\Boleto\Boleto
     */
    public function setSacado($sacado)
    {
        $this->sacado = $sacado;
        return $this;
    }

    /**
     * Retorna a instancia do banco
     * @return Banco
     */
    public function getBanco()
    {
        return $this->banco;
    }

    /**
     * Retorna o valor do documento
     * @return float
     */
    public function getValorDocumento()
    {
        return $this->valorDocumento + $this->taxa;
    }

    /**
     * Retorna a data de vencimento
     * @return \DateTime
     */
    public function getDataVencimento()
    {
        return $this->dataVencimento;
    }

    /**
     * Retorna o codigo de barras
     * @return int
     */
    public function getCodigoBarras()
    {
        return $this->codigoBarras;
    }

    /**
     * Retorna a linha digitavel
     * @return int
     */
    public function getLinhaDigitavel()
    {
        return $this->linhaDigitavel;
    }

    /**
     * Define o numero do banco
     * @param int $banco
     * @return \Umbrella\YA\Boleto\Boleto
     */
    public function setBanco($banco)
    {
        $this->banco = $banco;
        return $this;
    }

    /**
     * Define o valor do documento
     * @param float $valorDocumento
     * @return \Umbrella\YA\Boleto\Boleto
     */
    public function setValorDocumento($valorDocumento)
    {
        $this->valorDocumento = $valorDocumento;
        return $this;
    }

    /**
     * Define a data de venciemnto
     * @param \DateTime $dataVencimento
     * @return \Umbrella\YA\Boleto\Boleto
     */
    public function setDataVencimento(\DateTime $dataVencimento)
    {
        $this->dataVencimento = $dataVencimento;
        return $this;
    }

}
