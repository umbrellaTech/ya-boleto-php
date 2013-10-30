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

use DateTime;
use Umbrella\Api\Boleto\BoletoInterface;

/**
 * Clase abstrata que representa o Boleto. Os dados da classe foram retirados da FEBRABAN
 * @author italo <italolelis@lellysinformatica.com>
 * @since 1.0.0
 */
abstract class Boleto implements BoletoInterface
{

    /**
     * @var Convenio
     */
    protected $convenio;

    /**
     * @var Cedente 
     */
    protected $cendente;

    /**
     * @var Sacado
     */
    protected $sacado;
    protected $valorDocumento;
    protected $dataVencimento;
    protected $taxa;
    protected $numeroDocumento;
    protected $codigoBarras;
    protected $linhaDigitavel;

    /**
     * Cria uma nova instancia do Boleto
     * @param Banco $banco Instancia do Banco para o boleto
     */
    public function __construct(Sacado $sacado, Cedente $cedente, Convenio $convenio)
    {
        $this->convenio = $convenio;
        $this->sacado = $sacado;
        $this->cendente = $cedente;
        $this->codigoBarras = $this->getCodigoBarras();
        $this->linhaDigitavel = $this->gerarLinhaDigitavel($this->codigoBarras);
    }

    /**
     * Gera o codigo de barras, baseado nas informaoes do banco
     */
    protected abstract function gerarCodigoBarras();

    /**
     * Retorna o convenio do boleto
     * @return Convenio
     */
    public function getConvenio()
    {
        return $this->convenio;
    }

    /**
     * Define o convenio do boleto
     * @param Convenio $convenio
     * @return Boleto
     */
    public function setConvenio(Convenio $convenio)
    {
        $this->convenio = $convenio;
        return $this;
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
     * Define a taxa do boleto
     * @param float $taxa
     * @return Boleto
     */
    public function setTaxa($taxa)
    {
        $this->taxa = $taxa;
        return $this;
    }

    /**
     * Define o numero do documento
     * @param int $numeroDocumento
     * @return Boleto
     */
    public function setNumeroDocumento($numeroDocumento)
    {
        $this->numeroDocumento = $numeroDocumento;
        return $this;
    }

    /**
     * Retorna o cedente
     * @return Pessoa
     */
    public function getCendente()
    {
        return $this->cendente;
    }

    /**
     * Retorna o sacado
     * @return Pessoa
     */
    public function getSacado()
    {
        return $this->sacado;
    }

    /**
     * Define o cedente
     * @param Pessoa $cendente
     * @return Boleto
     */
    public function setCendente(Pessoa $cendente)
    {
        $this->cendente = $cendente;
        return $this;
    }

    /**
     * Define o sacado
     * @param Pessoa $sacado
     * @return Boleto
     */
    public function setSacado(Pessoa $sacado)
    {
        $this->sacado = $sacado;
        return $this;
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
     * @return DateTime
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
     * Define o valor do documento
     * @param float $valorDocumento
     * @return Boleto
     */
    public function setValorDocumento($valorDocumento)
    {
        $this->valorDocumento = $valorDocumento;
        return $this;
    }

    /**
     * Define a data de venciemnto
     * @param DateTime $dataVencimento
     * @return Boleto
     */
    public function setDataVencimento(DateTime $dataVencimento)
    {
        $this->dataVencimento = $dataVencimento;
        return $this;
    }

}
