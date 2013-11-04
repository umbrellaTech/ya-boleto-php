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

namespace Umbrella\YA\Boleto\Boleto;

use Umbrella\YA\Boleto\Boleto;
use Umbrella\YA\Boleto\Moedas;
use Umbrella\YA\Boleto\Type\Number;
use Umbrella\YA\Boleto\Type\String;

/**
 * Clase abstrata que representa o Boleto do Banco do Brasil
 * @author italo <italolelis@lellysinformatica.com>
 * @since 1.0.0
 */
class BancoBrasil extends Boleto
{

    public $tamanhos = array(
        #Campos comuns a todos os bancos
        'Banco' => 3, //identificação do banco
        'Moeda' => 1, //Código da moeda: real=9
        'DV' => 1, //Dígito verificador geral da linha digitável
        'FatorVencimento' => 4, //Fator de vencimento (Dias passados desde 7/out/1997)
        'Valor' => 10, //Valor nominal do título
        #Campos variávies
        'Agencia' => 4, //Código da agencia, sem dígito
        'Conta' => 8, //Número da conta
        'CodigoCedente' => 7, //Número do convênio fornecido pelo banco
        'DigitoConta' => 1, //Dígito da conta do Cedente
        'NossoNumero' => 10, //Nosso número
        'DigitoNossoNumero' => 5, //Dígito do nosso número
        'Carteira' => 2, //Código da carteira
    );
    protected $mascara = "00000.00000 00000.000000 00000.000000 0 00000000000000";

    protected function gerarCodigoBarras()
    {
        //Teste do ooboleto
        $banco = $this->convenio->getBanco();
        $data = array(
            'Banco' => $banco->getNumero(),
            'Moeda' => Moedas::REAL,
            'Valor' => Number::format($this->getValorDocumento()),
            'Agencia' => $banco->getAgencia(),
            'Carteira' => $this->convenio->getCarteira()->getNumero(),
            'Conta' => $banco->getAgencia(),
            'NossoNumero' => $this->convenio->getNossoNumero(),
            'FatorVencimento' => Number::fatorVencimento($this->getDataVencimento()->format("d/m/Y")),
            'CodigoCedente' => $this->getConvenio()->getConvenio()
        );

        foreach ($data as $var => $value) {
            if (array_key_exists($var, $this->tamanhos)) {
                $data[$var] = String::normalize($data[$var], $this->tamanhos[$var]);
            }
        }

        $data['Vencimento'] = $this->dataVencimento->format("d/m/Y");
        $data['DigitoAgencia'] = Number::modulo11($data['Agencia']);
        $data['DigitoConta'] = Number::modulo11($data['Conta']);
        $data['DigitoNossoNumero'] = Number::modulo11($data['NossoNumero']);

        $cod = String::insert($this->convenio->getCarteira()->getLayout(), $data);

        //Cálculo do dígito verificador geral do código de barras
        $dv = Number::modulo11($cod, 1, 1);
        //Inserindo o dígito verificador exatamente na posição 4, iniciando em 0.
        $codigoBarras = String::putAt($cod, $dv, 4);

        return $codigoBarras;
    }

    public function gerarLinhaDigitavel($codigoBarras)
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

}
