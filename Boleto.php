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

use DateTime;
use Umbrella\Ya\Boleto\Type\Number;
use Umbrella\Ya\Boleto\Type\String;

/**
 * Clase abstrata que representa o Boleto. Os dados da classe foram retirados da FEBRABAN
 * @author italo <italolelis@lellysinformatica.com>
 * @since 1.0.0
 */
abstract class Boleto
{

    /**
     * @var AbstractConvenio
     */
    protected $convenio;

    /**
     * @var Cedente 
     */
    protected $cedente;

    /**
     * @var Sacado
     */
    protected $sacado;
    protected $valorDocumento;
    protected $dataVencimento;
    protected $dataDocumento;
    protected $taxa;
    protected $desconto;
    protected $outrasDeducoes;
    protected $multa;
    protected $outrosAcrescimos;
    protected $numeroDocumento;
    protected $instrucoes;
    protected $quantidade;
    protected $aceite;
    protected $especie;
    protected $localPagamento;
    protected $codigoBarras;
    protected $linhaDigitavel;
    protected $mascara = "00000.00000 00000.000000 00000.000000 0 00000000000000";

    /**
     * Cria uma nova instancia do Boleto
     * @param Banco $banco Instancia do Banco para o boleto
     */
    public function __construct(Sacado $sacado, Cedente $cedente, AbstractConvenio $convenio)
    {
        $this->convenio = $convenio;
        $this->sacado = $sacado;
        $this->cedente = $cedente;
        $this->dataDocumento = new DateTime();
    }

    /**
     * Gera o codigo de barras, baseado nas informaoes do banco
     */
    protected function gerarCodigoBarras()
    {
        //Teste do ooboleto
        $banco = $this->convenio->getBanco();
        $convenio = $this->convenio;

        $total = $this->getTotal();

        if ($total < 0) {
            throw new \LogicException("Valor total do boleto não pode ser negativo");
        }

        $valor = Number::format($total);
        $agencia = substr($banco->getAgencia(), 0, 4);
        $conta = substr($banco->getConta(), 0, 4);

        $data = new \ArrayObject(array(
            'Banco' => $banco->getNumero(),
            'Moeda' => Moedas::REAL,
            'Valor' => $valor,
            'Agencia' => $agencia,
            'Carteira' => $convenio->getCarteira()->getNumero(),
            'Conta' => $conta,
            'NossoNumero' => $convenio->getNossoNumero(),
            'FatorVencimento' => Number::fatorVencimento($this->getDataVencimento()->format("d/m/Y")),
            'CodigoCedente' => $convenio->getConvenio()
        ));
        $data->setFlags(\ArrayObject::ARRAY_AS_PROPS);

        $tamanhos = $convenio->getTamanhos();

        foreach ($data as $var => $value) {
            if (array_key_exists($var, $tamanhos)) {
                $data[$var] = String::normalize($data[$var], $tamanhos[$var]);
            }
        }

        $this->getConvenio()->gerarCampoLivre($data, $this);

        $cod = String::insert($convenio->getLayout(), $data);

        //Isso deveria ser um observer para todos os interessados nesse evento
        if (method_exists($this, 'afterGeneration')) {
            $this->afterGeneration($cod);
        }

        //Cálculo do dígito verificador geral do código de barras
        $dv = Number::modulo11($cod, 1, 1);
        //Inserindo o dígito verificador exatamente na posição 4, iniciando em 0.
        $codigoBarras = String::putAt($cod, $dv, 4);
        //Debugger::dump($codigoBarras);
        return $codigoBarras;
    }

    /**
     * Gera a linha digitavel baseado em um codigo de barras
     * @param string $codigoBarras
     * @return string
     */
    protected function gerarLinhaDigitavel($codigoBarras)
    {
        //Campo1 - Posições de 1-4 e 20-24
        $linhaDigitavel = substr($codigoBarras, 0, 4) . substr($codigoBarras, 19, 5)
                //Campo2 - Posições 25-34
                . substr($codigoBarras, 24, 10)
                //Campo3 - Posições 35-44
                . substr($codigoBarras, 34, 10)
                //Campo4 - Posição 5
                . substr($codigoBarras, 4, 1)
                //Campo5 - Posições 6-19
                . substr($codigoBarras, 5, 14);

        $dv1 = Number::modulo10(substr($linhaDigitavel, 0, 9));
        $dv2 = Number::modulo10(substr($linhaDigitavel, 9, 10));
        $dv3 = Number::modulo10(substr($linhaDigitavel, 19, 10));

        $linhaDigitavel = String::putAt($linhaDigitavel, $dv3, 29);
        $linhaDigitavel = String::putAt($linhaDigitavel, $dv2, 19);
        $linhaDigitavel = String::putAt($linhaDigitavel, $dv1, 9);

        return String::applyMask($linhaDigitavel, $this->mascara);
    }

    /**
     * Retorna a Quantidade
     * @return int
     */
    public function getQuantidade()
    {
        return $this->quantidade;
    }

    /**
     * Retorna o Aceite
     * @return string
     */
    public function getAceite()
    {
        return $this->aceite;
    }

    /**
     * Retorna a especie para o boleto
     * @return string
     */
    public function getEspecie()
    {
        return $this->especie;
    }

    /**
     * Retorna o local de pagamento
     * @return string
     */
    public function getLocalPagamento()
    {
        return $this->localPagamento;
    }

    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;
        return $this;
    }

    public function setAceite($aceite)
    {
        $this->aceite = $aceite;
        return $this;
    }

    public function setEspecie($especie)
    {
        $this->especie = $especie;
        return $this;
    }

    public function setLocalPagamento($localPagamento)
    {
        $this->localPagamento = $localPagamento;
        return $this;
    }

    public function getInstrucoes()
    {
        return $this->instrucoes;
    }

    public function setInstrucoes($instrucoes)
    {
        $this->instrucoes = $instrucoes;
        return $this;
    }

    public function getDesconto()
    {
        return $this->desconto;
    }

    public function getOutrasDeducoes()
    {
        return $this->outrasDeducoes;
    }

    public function getMulta()
    {
        return $this->multa;
    }

    public function getOutrosAcrescimos()
    {
        return $this->outrosAcrescimos;
    }

    public function setDesconto($desconto)
    {
        $this->desconto = $desconto;
        return $this;
    }

    public function setOutrasDeducoes($outrasDeducoes)
    {
        $this->outrasDeducoes = $outrasDeducoes;
        return $this;
    }

    public function setMulta($multa)
    {
        $this->multa = $multa;
        return $this;
    }

    public function setOutrosAcrescimos($outrosAcrescimos)
    {
        $this->outrosAcrescimos = $outrosAcrescimos;
        return $this;
    }

    public function getDataDocumento()
    {
        return $this->dataDocumento;
    }

    public function setDataDocumento($dataDocumento)
    {
        $this->dataDocumento = $dataDocumento;
        return $this;
    }

    /**
     * Retorna o convenio do boleto
     * @return AbstractConvenio
     */
    public function getConvenio()
    {
        return $this->convenio;
    }

    /**
     * Define o convenio do boleto
     * @param AbstractConvenio $convenio
     * @return Boleto
     */
    public function setConvenio(AbstractConvenio $convenio)
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
    public function getCedente()
    {
        return $this->cedente;
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
    public function setCedente(Pessoa $cendente)
    {
        $this->cedente = $cendente;
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
     * @return string
     */
    public function getValorDocumento()
    {
        return $this->valorDocumento;
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
        $this->codigoBarras = $this->gerarCodigoBarras();
        $this->linhaDigitavel = $this->gerarLinhaDigitavel($this->codigoBarras);

        return $this->linhaDigitavel;
    }

    /**
     * Define o valor do documento
     * @param string $valorDocumento
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

    /**
     * Retorna a data de vencimento
     * @return DateTime
     */
    public function getTotal()
    {
        return $this->valorDocumento + $this->taxa - $this->desconto + $this->outrosAcrescimos - $this->outrasDeducoes;
    }

}
