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
use Umbrella\YaBoleto\Type\StringBuilder;

/**
 * Classe abstrata que representa um boleto.
 *
 * @author  Italo Lelis <italolelis@lellysinformatica.com>
 * @package YaBoleto
 */
abstract class AbstractBoleto
{
    /** @var \Umbrella\YaBoleto\AbstractConvenio */
    protected $convenio;
    /** @var \Umbrella\YaBoleto\Cedente */
    protected $cedente;
    /** @var \Umbrella\YaBoleto\Sacado */
    protected $sacado;
    /** @var float */
    protected $valorDocumento;
    /** @var \DateTime */
    protected $dataVencimento;
    /** @var \DateTime */
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
    /** @var string */
    protected $codigoBarras;
    /** @var string */
    protected $linhaDigitavel;
    /** @var string */
    protected $mascara = "00000.00000 00000.000000 00000.000000 0 00000000000000";
    /** @var array */
    protected $erros = array();
    /** @var integer */
    protected $moeda = 9;

    /**
     * Inicializa uma nova instância da classe.
     *
     * @param \Umbrella\YaBoleto\Sacado $sacado
     * @param \Umbrella\YaBoleto\Cedente $cedente
     * @param \Umbrella\YaBoleto\AbstractConvenio $convenio
     */
    public function __construct(Sacado $sacado, Cedente $cedente, AbstractConvenio $convenio)
    {
        $this->sacado = $sacado;
        $this->cedente = $cedente;
        $this->convenio = $convenio;
        $this->dataDocumento = new \DateTime();
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
     * @return \Umbrella\YaBoleto\AbstractBoleto $this
     */
    public function setValorDocumento($valorDocumento)
    {
        $this->valorDocumento = $valorDocumento;

        return $this;
    }

    /**
     * Define a data de venciemnto.
     *
     * @param  \DateTime $dataVencimento
     * @return \Umbrella\YaBoleto\AbstractBoleto $this
     */
    public function setDataVencimento(\DateTime $dataVencimento)
    {
        $this->dataVencimento = $dataVencimento;

        return $this;
    }

    /**
     * Define a data do documento.
     *
     * @param  \DateTime $dataDocumento
     * @return \Umbrella\YaBoleto\AbstractBoleto $this
     */
    public function setDataDocumento(\DateTime $dataDocumento)
    {
        $this->dataDocumento = $dataDocumento;

        return $this;
    }

    /**
     * Define a taxa do boleto.
     *
     * @param  float $taxa
     * @return \Umbrella\YaBoleto\AbstractBoleto $this
     */
    public function setTaxa($taxa)
    {
        $this->taxa = $taxa;

        return $this;
    }

    /**
     * Define o desconto do boleto.
     *
     * @param  double $desconto
     * @return \Umbrella\YaBoleto\AbstractBoleto $this
     */
    public function setDesconto($desconto)
    {
        $this->desconto = $desconto;

        return $this;
    }

    /**
     * Define o valor de outras deduções.
     *
     * @param  float $outrasDeducoes
     * @return \Umbrella\YaBoleto\AbstractBoleto $this
     */
    public function setOutrasDeducoes($outrasDeducoes)
    {
        $this->outrasDeducoes = $outrasDeducoes;

        return $this;
    }

    /**
     * Define o valor de multa.
     *
     * @param  float $multa
     * @return \Umbrella\YaBoleto\AbstractBoleto $this
     */
    public function setMulta($multa)
    {
        $this->multa = $multa;

        return $this;
    }

    /**
     * Define o valor de outros acréscimos.
     *
     * @param  float $outrosAcrescimos
     * @return \Umbrella\YaBoleto\AbstractBoleto $this
     */
    public function setOutrosAcrescimos($outrosAcrescimos)
    {
        $this->outrosAcrescimos = $outrosAcrescimos;

        return $this;
    }

    /**
     * Define o número do documento.
     *
     * @param  integer $numeroDocumento
     * @return \Umbrella\YaBoleto\AbstractBoleto $this
     */
    public function setNumeroDocumento($numeroDocumento)
    {
        $this->numeroDocumento = $numeroDocumento;

        return $this;
    }

    /**
     * Define as instruções do documento.
     *
     * @param  array $instrucoes
     * @return \Umbrella\YaBoleto\AbstractBoleto $this
     */
    public function setInstrucoes(array $instrucoes)
    {
        $this->instrucoes = $instrucoes;

        return $this;
    }

    /**
     * Define o demonstrativo do documento.
     *
     * @param  array $demonstrativo
     * @return \Umbrella\YaBoleto\AbstractBoleto $this
     */
    public function setDemonstrativo(array $demonstrativo)
    {
        $this->demonstrativo = $demonstrativo;

        return $this;
    }

    /**
     * Define a quantidade.
     *
     * @param  integer $quantidade
     * @return \Umbrella\YaBoleto\AbstractBoleto $this
     */
    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;

        return $this;
    }

    /**
     * Define o aceite.
     *
     * @param  string $aceite
     * @return \Umbrella\YaBoleto\AbstractBoleto $this
     */
    public function setAceite($aceite)
    {
        $this->aceite = $aceite;

        return $this;
    }

    /**
     * Define a espécie.
     *
     * @param  string $especie
     * @return \Umbrella\YaBoleto\AbstractBoleto $this
     */
    public function setEspecie($especie)
    {
        $this->especie = $especie;

        return $this;
    }

    /**
     * Define o local de pagamento.
     *
     * @param  string $localPagamento
     * @return \Umbrella\YaBoleto\AbstractBoleto $this
     */
    public function setLocalPagamento($localPagamento)
    {
        $this->localPagamento = $localPagamento;

        return $this;
    }

    /**
     * Retorna o convênio do boleto.
     *
     * @return \Umbrella\YaBoleto\AbstractConvenio
     */
    public function getConvenio()
    {
        return $this->convenio;
    }

    /**
     * Retorna o cedente.
     *
     * @return \Umbrella\YaBoleto\Pessoa
     */
    public function getCedente()
    {
        return $this->cedente;
    }

    /**
     * Retorna o sacado.
     *
     * @return \Umbrella\YaBoleto\Pessoa
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
     * @return \DateTime
     */
    public function getDataVencimento()
    {
        return $this->dataVencimento;
    }

    /**
     * Retorna a data do documento.
     *
     * @return \DateTime
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
     * @return string
     */
    public function getCodigoBarras()
    {
        return $this->codigoBarras;
    }

    /**
     * Retorna a linha digitável.
     *
     * @return string
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
     * Gera o código de barras e a linha digitavel.
     *
     * @return $this
     */
    public function gerarCodigoBarraLinhaDigitavel()
    {
        $this->codigoBarras = $this->gerarCodigoBarras();
        $this->linhaDigitavel = $this->gerarLinhaDigitavel($this->codigoBarras);

        return $this;
    }

    /**
     * Gera o código de barras, baseado nas informações do banco.
     *
     * @return string
     */
    protected function gerarCodigoBarras()
    {
        $banco = $this->convenio->getBanco();
        $convenio = $this->convenio;
        $total = $this->getTotal();

        if ($total < 0) {
            throw new \LogicException("Valor total do boleto não pode ser negativo");
        }

        $valor = Number::format($total);
        $agencia = substr($banco->getAgencia(), 0, 4);
        $conta = substr($banco->getConta(), 0, 4);

        $data = new ArrayObject(array(
            'Banco' => $banco->getNumero(),
            'Moeda' => $this->moeda,
            'Valor' => $valor,
            'Agencia' => $agencia,
            'Carteira' => $convenio->getCarteira()->getNumero(),
            'Conta' => $conta,
            'NossoNumero' => $convenio->getNossoNumero(),
            'FatorVencimento' => Number::fatorVencimento($this->getDataVencimento()),
            'CodigoCedente' => $convenio->getConvenio()
        ));
        $data->setFlags(ArrayObject::ARRAY_AS_PROPS);

        $this->getConvenio()->gerarCampoLivre($data);

        $tamanhos = $convenio->getTamanhos();

        foreach ($data as $var => $value) {
            if (array_key_exists($var, $tamanhos)) {
                $data[$var] = StringBuilder::normalize($data[$var], $tamanhos[$var]);
            }
        }

        //Chamada do método que ajusta o NossoNumero
        $this->getConvenio()->ajustarNossoNumero($data);

        $convenio->setNossoNumero($data['NossoNumero']);

        $cod = StringBuilder::insert($convenio->getLayout(), $data);

        $dv = Number::modulo11($cod, 1, 1);

        $codigoBarras = StringBuilder::putAt($cod, $dv, 4);

        return $codigoBarras;
    }

    /**
     * Gera a linha digitável baseado em um código de barras.
     *
     * @param  string $codigoBarras
     * @return string
     */
    protected function gerarLinhaDigitavel($codigoBarras)
    {
        // Campo1 - Posições de 1-4 e 20-24
        $linhaDigitavel = substr($codigoBarras, 0, 4) . substr($codigoBarras, 19, 5)
            // Campo2 - Posições 25-34
            . substr($codigoBarras, 24, 10)
            // Campo3 - Posições 35-44
            . substr($codigoBarras, 34, 10)
            // Campo4 - Posição 5
            . substr($codigoBarras, 4, 1)
            // Campo5 - Posições 6-19
            . substr($codigoBarras, 5, 14);

        $dv1 = Number::modulo10(substr($linhaDigitavel, 0, 9));
        $dv2 = Number::modulo10(substr($linhaDigitavel, 9, 10));
        $dv3 = Number::modulo10(substr($linhaDigitavel, 19, 10));

        $linhaDigitavel = StringBuilder::putAt($linhaDigitavel, $dv3, 29);
        $linhaDigitavel = StringBuilder::putAt($linhaDigitavel, $dv2, 19);
        $linhaDigitavel = StringBuilder::putAt($linhaDigitavel, $dv1, 9);

        return StringBuilder::applyMask($linhaDigitavel, $this->mascara);
    }

}
