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

namespace Umbrella\YaBoleto\Builder;

use DateTime;
use ReflectionClass;
use Umbrella\YaBoleto\AbstractBoleto;
use Umbrella\YaBoleto\BancoInterface;
use Umbrella\YaBoleto\Calculator\CodigoBarrasCalculator;
use Umbrella\YaBoleto\Calculator\LinhaDigitavelCalulator;
use Umbrella\YaBoleto\CarteiraInterface;
use Umbrella\YaBoleto\Cedente;
use Umbrella\YaBoleto\Cnpj;
use Umbrella\YaBoleto\ConvenioInterface;
use Umbrella\YaBoleto\Cpf;
use Umbrella\YaBoleto\Endereco;
use Umbrella\YaBoleto\PessoaFisica;
use Umbrella\YaBoleto\PessoaJuridica;
use Umbrella\YaBoleto\Sacado;

/**
 * Classe do Builder de Boletos
 *
 * @author  Italo Lelis de Vietro <italolelis@gmail.com>
 * @package YaBoleto
 */
class BoletoBuilder
{
    /** @var string */
    protected $type;
    /** @var string */
    protected $namespace;
    /** @var Sacado */
    protected $sacado;
    /** @var Cedente */
    protected $cedente;
    /** @var BancoInterface */
    protected $banco;
    /** @var CarteiraInterface */
    protected $carteira;
    /** @var ConvenioInterface */
    protected $convenio;

    // Tipos de Pessoa do Sacado
    const PESSOA_FISICA = 'física';
    const PESSOA_JURIDICA = 'jurídica';

    /**
     * Inicializa uma nova instância da classe.
     *
     * @param string $banco Nome do banco a gerar o boleto
     */
    public function __construct($banco)
    {
        $this->type = str_replace(" ", "", ucwords(trim($banco)));
        $this->namespace = "Umbrella\\YaBoleto\\Bancos\\" . $this->type;
    }

    /**
     * Define o sacado.
     *
     * @param  string $tipo Tipo de pessoa do sacado
     * @param  string $nome Nome do sacado
     * @param  string $documento CPF/CNPJ do sacado
     * @param  Endereco $endereco Endereço do sacado
     * @return \Umbrella\YaBoleto\Builder\BoletoBuilder
     */
    public function sacado($tipo, $nome, $documento, Endereco $endereco)
    {
        if ($tipo === self::PESSOA_FISICA) {
            $sacado = new PessoaFisica($nome, new Cpf($documento), $endereco);
        } else {
            if ($tipo === self::PESSOA_JURIDICA) {
                $sacado = new PessoaJuridica($nome, new Cnpj($documento), $endereco);
            } else {
                throw new \InvalidArgumentException("Tipo de pessoa inválido! Valores válidos: 'física' ou 'jurídica'.");
            }
        }

        $this->sacado = new Sacado($sacado);

        return $this;
    }

    /**
     * Define o cedente.
     *
     * @param  string $nome Nome do cedente
     * @param  string $documento CNPJ do cedente
     * @param  Endereco $endereco Endereço do cedente
     * @return \Umbrella\YaBoleto\Builder\BoletoBuilder
     */
    public function cedente($nome, $documento, Endereco $endereco)
    {
        $this->cedente = new Cedente($nome, new Cnpj($documento), $endereco);

        return $this;
    }

    /**
     * Define o banco.
     *
     * @param  string $agencia Agência bancária favorecida
     * @param  string $conta Conta bancária favorecida
     * @return \Umbrella\YaBoleto\Builder\BoletoBuilder
     */
    public function banco($agencia, $conta)
    {
        $reflection = new ReflectionClass($this->namespace . '\\' . $this->type);
        $this->banco = $reflection->newInstanceArgs(array($agencia, $conta));

        return $this;
    }

    /**
     * Define a carteira.
     *
     * @param  string $carteira Número da carteira
     * @return \Umbrella\YaBoleto\Builder\BoletoBuilder
     */
    public function carteira($carteira)
    {
        $reflection = new ReflectionClass($this->namespace . '\\Carteira\\Carteira' . $carteira);
        $this->carteira = $reflection->newInstanceArgs();

        return $this;
    }

    /**
     * Define a convênio.
     *
     * @param  string $convenio Número do convênio
     * @param  string $nossoNumero Nosso número
     * @return \Umbrella\YaBoleto\Builder\BoletoBuilder
     */
    public function convenio($convenio, $nossoNumero)
    {
        $reflection = new ReflectionClass($this->namespace . '\\Convenio');
        $this->convenio = $reflection->newInstanceArgs(array($this->banco, $this->carteira, $convenio, $nossoNumero));

        return $this;
    }

    /**
     * Constrói o boleto.
     *
     * @param  float $valor Valor do boleto
     * @param  integer $numeroDocumento Número do documento
     * @param  DateTime $vencimento Data de vencimento
     * @return \Umbrella\YaBoleto\AbstractBoleto
     */
    public function build($valor, $numeroDocumento, DateTime $vencimento)
    {
        $reflection = new ReflectionClass($this->namespace . '\\Boleto\\' . $this->type);

        /** @var AbstractBoleto $boleto */
        $boleto = $reflection->newInstanceArgs(array($this->sacado, $this->cedente, $this->convenio));
        $boleto->setValorDocumento($valor)
            ->setNumeroDocumento($numeroDocumento)
            ->setDataVencimento($vencimento);

        $codigoBarrasCalculator = new CodigoBarrasCalculator();
        $codigoBarras = $codigoBarrasCalculator->calculate($boleto);

        $linhaDigitavelCalculator = new LinhaDigitavelCalulator();
        $linhaDigitavel = $linhaDigitavelCalculator->calculate($codigoBarras);

        $boleto->setCodigoBarras($codigoBarras)
            ->setLinhaDigitavel($linhaDigitavel);

        return $boleto;
    }
}
