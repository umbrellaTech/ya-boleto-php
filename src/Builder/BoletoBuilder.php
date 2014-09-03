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
namespace Umbrella\Ya\Boleto\Builder;

use DateTime;
use ReflectionClass;
use Umbrella\Ya\Boleto\Cedente;
use Umbrella\Ya\Boleto\PessoaFisica;
use Umbrella\Ya\Boleto\Sacado;

class BoletoBuilder
{
    protected $type;
    protected $namespace;
    protected $sacado;
    protected $cedente;
    protected $banco;
    protected $carteira;
    protected $convenio;

    /**
     * Inicializa uma instância da classe BoletoBuilder.
     * @param string $banco O nome do banco para a geração do boleto.
     */
    public function __construct($banco)
    {
        $this->type = str_replace(" ", "", ucwords(trim($banco)));
        $this->namespace = 'Umbrella\Ya\Boleto\Bancos\\' . $this->type;
    }

    /**
     * Define o sacado para a geração do boleto.
     * @param string $nome O nome do sacado.
     * @param string $documento O documento (CPF ou CNPJ) do sacado.
     * @return \Umbrella\Ya\Boleto\Builder\BoletoBuilder
     */
    public function sacado($nome, $documento)
    {
        $pf = new PessoaFisica($nome, $documento);
        $this->sacado = new Sacado($pf);
        return $this;
    }

    /**
     * Define o cedente para a geração do boleto.
     * @param string $nome O nome do cendente.
     * @param string $cnpj O CNPJ do cedente.
     * @return \Umbrella\Ya\Boleto\Builder\BoletoBuilder
     */
    public function cedente($nome, $cnpj)
    {
        $this->cedente = new Cedente($nome, $cnpj);
        return $this;
    }

    /**
     * Define os dados do banco para a geração do boleto.
     * @param int $agencia A agência bancária.
     * @param int $conta A conta bancária.
     * @return \Umbrella\Ya\Boleto\Builder\BoletoBuilder
     */
    public function banco($agencia, $conta)
    {
        $reflection = new ReflectionClass($this->namespace . '\\' . $this->type);
        $this->banco = $reflection->newInstanceArgs(array($agencia, $conta));
        return $this;
    }

    /**
     * Define a carteira para a geração do boleto.
     * @param int $numero O número da carteira.
     * @return \Umbrella\Ya\Boleto\Builder\BoletoBuilder
     */
    public function carteira($numero)
    {
        $reflection = new ReflectionClass($this->namespace . '\\Carteira\\Carteira' . $numero);
        $this->carteira = $reflection->newInstanceArgs();
        return $this;
    }

    /**
     * Define o convênio para a geração do boleto.
     * @param int $numero O número do convênio.
     * @param int $nossoNumero O nosso número.
     * @return \Umbrella\Ya\Boleto\Builder\BoletoBuilder
     */
    public function convenio($numero, $nossoNumero)
    {
        $reflection = new ReflectionClass($this->namespace . '\\Convenio');
        $this->convenio = $reflection->newInstanceArgs(array($this->banco, $this->carteira, $numero, $nossoNumero));
        return $this;
    }

    /**
     * Constroi um objeto Boleto.
     * @param float $valor O valor do boleto.
     * @param int $numeroDocumento O número do documento.
     * @param DateTime $vencimento O vencimento do boleto.
     * @return \Umbrella\Ya\Boleto\Boleto
     */
    public function build($valor, $numeroDocumento, DateTime $vencimento)
    {
        $reflection = new ReflectionClass($this->namespace . '\\Boleto\\' . $this->type);
        $boleto = $reflection->newInstanceArgs(array($this->sacado, $this->cedente, $this->convenio));
        $boleto->setValorDocumento($valor)
            ->setNumeroDocumento($numeroDocumento)
            ->setDataVencimento($vencimento);
        return $boleto;
    }
}
