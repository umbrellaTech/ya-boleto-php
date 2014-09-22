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

namespace Umbrella\Ya\Boleto\Bancos\CaixaEconomica;

use ArrayObject;
use Umbrella\Ya\Boleto\AbstractConvenio;
use Umbrella\Ya\Boleto\Type\Number;
use Umbrella\Ya\Boleto\Type\String;

/**
 * Clase abstrata que representa o Convenio
 * @author edmo <edmofarias@gmail.com>
 * @since 1.0.0
 */
class Convenio extends AbstractConvenio
{

    public function gerarCampoLivre(ArrayObject $data)
    {
        $this->alterarTamanho('NossoNumero', 17);
        $this->alterarTamanho('CodigoCedente', 7); //6 digitos + DV
        $this->alterarTamanho('CampoLivre', 18); //17 digitos + DV

        $data['CodigoCedente'] .= Number::modulo11($data['CodigoCedente'], 0, 0, false);

        $nossoNumero = String::normalize($data['NossoNumero'], 17);

        $constante1 = '2'; //1ª posição do Nosso Numero:Tipo de Cobrança (1-Registrada / 2-Sem Registro)
        $constante2 = '4'; //2ª posição do Nosso Número:Identificador da Emissão do Boleto (4-Beneficiário)
        $sequencia1 = (String) substr($nossoNumero, 2, 3);
        $sequencia2 = (String) substr($nossoNumero, 5, 3);
        $sequencia3 = (String) substr($nossoNumero, 8, 9);

        if ($data['Carteira'] == 'RG') {
            $constante1 = '1'; //1ª posição do Nosso Numero:Tipo de Cobrança (1-Registrada / 2-Sem Registro)
        }

        $data['CampoLivre'] = $sequencia1 . $constante1 . $sequencia2 . $constante2 . $sequencia3;

        //Calculando o DV do campo livre
        $campoLivre = $data['CodigoCedente'] . $data['CampoLivre'];
        $data['CampoLivre'] .= Number::modulo11($campoLivre, 0, 0, false);

        $this->layout = ':Banco:Moeda:FatorVencimento:Valor:CodigoCedente:CampoLivre';
    }

}
