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

use DateTime;

/**
 * Classe abstrata que representa um boleto.
 *
 * @author  Italo Lelis de Vietro <italolelis@gmail.com>
 * @package YaBoleto
 */
abstract class AbstractBoleto
{
    /** @var ConvenioInterface */
    protected $convenio;
    /** @var Cedente */
    protected $cedente;
    /** @var Sacado */
    protected $sacado;
    /** @var float */
    protected $valorDocumento;
    /** @var DateTime */
    protected $dataVencimento;
    /** @var DateTime */
    protected $dataDocumento;
    /** @var float */
    protected $taxa;
    /** @var float */
    protected $desconto;
    /** @var float */
    protected $outrasDeducoes;
    /** @var float */
    protected $multa;
    /** @var float */
    protected $outrosAcrescimos;
    /** @var string */
    protected $numeroDocumento;
    /** @var array */
    protected $instrucoes;
    /** @var array */
    protected $demonstrativo;
    /** @var integer */
    protected $quantidade;
    /** @var string */
    protected $aceite;
    /** @var string */
    protected $especie;
    /** @var string */
    protected $localPagamento;
    /** @var CodigoBarras */
    protected $codigoBarras;
    /** @var LinhaDigitavel */
    protected $linhaDigitavel;
    /** @var array */
    protected $erros = array();
    /** @var integer */
    protected $moeda = 9;

    /**
     * Inicializa uma nova instância da classe.
     *
     * @param Sacado $sacado
     * @param Cedente $cedente
     * @param ConvenioInterface $convenio
     */
    public function __construct(Sacado $sacado, Cedente $cedente, ConvenioInterface $convenio)
    {
        $this->sacado = $sacado;
        $this->cedente = $cedente;
        $this->convenio = $convenio;
        $this->dataDocumento = new DateTime();
    }

    /**
     * Valida todos os dados que são obrigatórios para a geraçao de qualquer boleto.
     *
     * @throws \InvalidArgumentException
     */
    public function validarDadosObrigatorios()
    {
        if (null === $this->getValorDocumento()) {
            $this->erros['valor'] = 'Valor do documento é obrigatório';
        }
        if (null === $this->getConvenio()->getBanco()->getAgencia()) {
            $this->erros['agencia'] = 'Agência do banco é obrigatório';
        }
        if (null === $this->getConvenio()->getBanco()->getConta()) {
            $this->erros['conta'] = 'Conta do banco é obrigatório';
        }
        if (null === $this->getConvenio()->getCarteira()->getNumero()) {
            $this->erros['carteira'] = 'Carteira do convênio é obrigatório';
        }
        if (!empty($this->erros)) {
            $dadosFaltantes = implode("', '", array_keys($this->erros));
            throw new \InvalidArgumentException("Faltam dados a serem fornecidos ao boleto. ('{$dadosFaltantes}')");
        }
    }

    /**
     * Define o valor do documento.
     *
     * @param  float $valorDocumento
     * @return $this
     */
    public function setValorDocumento($valorDocumento)
    {
        $this->valorDocumento = $valorDocumento;

        return $this;
    }

    /**
     * Define a data de venciemnto.
     *
     * @param DateTime $dataVencimento
     * @return $this
     */
    public function setDataVencimento(DateTime $dataVencimento)
    {
        $this->dataVencimento = $dataVencimento;

        return $this;
    }

    /**
     * Define a data do documento.
     *
     * @param  DateTime $dataDocumento
     * @return $this
     */
    public function setDataDocumento(DateTime $dataDocumento)
    {
        $this->dataDocumento = $dataDocumento;

        return $this;
    }

    /**
     * Define a taxa do boleto.
     *
     * @param float $taxa
     * @return $this
     */
    public function setTaxa($taxa)
    {
        $this->taxa = $taxa;

        return $this;
    }

    /**
     * Define o desconto do boleto.
     *
     * @param double $desconto
     * @return $this
     */
    public function setDesconto($desconto)
    {
        $this->desconto = $desconto;

        return $this;
    }

    /**
     * Define o valor de outras deduções.
     *
     * @param float $outrasDeducoes
     * @return $this
     */
    public function setOutrasDeducoes($outrasDeducoes)
    {
        $this->outrasDeducoes = $outrasDeducoes;

        return $this;
    }

    /**
     * Define o valor de multa.
     *
     * @param float $multa
     * @return $this
     */
    public function setMulta($multa)
    {
        $this->multa = $multa;

        return $this;
    }

    /**
     * Define o valor de outros acréscimos.
     *
     * @param float $outrosAcrescimos
     * @return $this
     */
    public function setOutrosAcrescimos($outrosAcrescimos)
    {
        $this->outrosAcrescimos = $outrosAcrescimos;

        return $this;
    }

    /**
     * Define o número do documento.
     *
     * @param int $numeroDocumento
     * @return $this
     */
    public function setNumeroDocumento($numeroDocumento)
    {
        $this->numeroDocumento = $numeroDocumento;

        return $this;
    }

    /**
     * Define as instruções do documento.
     *
     * @param array $instrucoes
     * @return $this
     */
    public function setInstrucoes(array $instrucoes)
    {
        $this->instrucoes = $instrucoes;

        return $this;
    }

    /**
     * Define o demonstrativo do documento.
     *
     * @param array $demonstrativo
     * @return $this
     */
    public function setDemonstrativo(array $demonstrativo)
    {
        $this->demonstrativo = $demonstrativo;

        return $this;
    }

    /**
     * Define a quantidade.
     *
     * @param int $quantidade
     * @return $this
     */
    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;

        return $this;
    }

    /**
     * Define o aceite.
     *
     * @param string $aceite
     * @return $this
     */
    public function setAceite($aceite)
    {
        $this->aceite = $aceite;

        return $this;
    }

    /**
     * Define a espécie.
     *
     * @param string $especie
     * @return $this
     */
    public function setEspecie($especie)
    {
        $this->especie = $especie;

        return $this;
    }

    /**
     * Define o local de pagamento.
     *
     * @param string $localPagamento
     * @return $this
     */
    public function setLocalPagamento($localPagamento)
    {
        $this->localPagamento = $localPagamento;

        return $this;
    }

    /**
     * Retorna o convênio do boleto.
     *
     * @return ConvenioInterface
     */
    public function getConvenio()
    {
        return $this->convenio;
    }

    /**
     * Retorna o cedente.
     *
     * @return Cedente
     */
    public function getCedente()
    {
        return $this->cedente;
    }

    /**
     * Retorna o sacado.
     *
     * @return Sacado
     */
    public function getSacado()
    {
        return $this->sacado;
    }

    /**
     * Retorna o valor do documento.
     *
     * @return float
     */
    public function getValorDocumento()
    {
        return $this->valorDocumento;
    }

    /**
     * Retorna a data de vencimento.
     *
     * @return DateTime
     */
    public function getDataVencimento()
    {
        return $this->dataVencimento;
    }

    /**
     * Retorna a data do documento.
     *
     * @return DateTime
     */
    public function getDataDocumento()
    {
        return $this->dataDocumento;
    }

    /**
     * Retorna o valor da taxa do boleto.
     *
     * @return float
     */
    public function getTaxa()
    {
        return $this->taxa;
    }

    /**
     * Retorna o valor do desconto.
     *
     * @return float
     */
    public function getDesconto()
    {
        return $this->desconto;
    }

    /**
     * Retorna o valor de outras deduções.
     *
     * @return float
     */
    public function getOutrasDeducoes()
    {
        return $this->outrasDeducoes;
    }

    /**
     * Retorna o valor de multa.
     *
     * @return float
     */
    public function getMulta()
    {
        return $this->multa;
    }

    /**
     * Retorna o valor de outros acréscimos.
     *
     * @return float
     */
    public function getOutrosAcrescimos()
    {
        return $this->outrosAcrescimos;
    }

    /**
     * Retorna o número do documento.
     *
     * @return integer
     */
    public function getNumeroDocumento()
    {
        return $this->numeroDocumento;
    }

    /**
     * Retorna as instruções do documento.
     *
     * @return array
     */
    public function getInstrucoes()
    {
        return $this->instrucoes;
    }

    /**
     * Retorna o demonstrativo do documento.
     *
     * @return array
     */
    public function getDemonstrativo()
    {
        return $this->demonstrativo;
    }

    /**
     * Retorna a quantidade.
     *
     * @return integer
     */
    public function getQuantidade()
    {
        return $this->quantidade;
    }

    /**
     * Retorna o aceite.
     *
     * @return string
     */
    public function getAceite()
    {
        return $this->aceite;
    }

    /**
     * Retorna a espécia.
     *
     * @return string
     */
    public function getEspecie()
    {
        return $this->especie;
    }

    /**
     * Retorna o local de pagamento.
     *
     * @return string
     */
    public function getLocalPagamento()
    {
        return $this->localPagamento;
    }

    /**
     * Retorna o código de barras.
     *
     * @return CodigoBarras
     */
    public function getCodigoBarras()
    {
        return $this->codigoBarras;
    }

    /**
     * Retorna a linha digitável.
     *
     * @return LinhaDigitavel
     */
    public function getLinhaDigitavel()
    {
        return $this->linhaDigitavel;
    }

    /**
     * Retorna as mensagens de errors depois da validação.
     *
     * @return array
     */
    public function getErros()
    {
        return $this->erros;
    }

    /**
     * Retorna a valor total do boleto.
     *
     * @return float
     */
    public function getTotal()
    {
        return (float)($this->valorDocumento + $this->taxa + $this->outrosAcrescimos) - ($this->desconto + $this->outrasDeducoes);
    }

    /**
     * @return int
     */
    public function getMoeda()
    {
        return $this->moeda;
    }

    /**
     * @param CodigoBarras $codigoBarras
     * @return $this
     */
    public function setCodigoBarras($codigoBarras)
    {
        $this->codigoBarras = $codigoBarras;

        return $this;
    }

    /**
     * @param LinhaDigitavel $linhaDigitavel
     * @return $this
     */
    public function setLinhaDigitavel($linhaDigitavel)
    {
        $this->linhaDigitavel = $linhaDigitavel;

        return $this;
    }
}
