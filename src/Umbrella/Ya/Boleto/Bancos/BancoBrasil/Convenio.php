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

namespace Umbrella\Ya\Boleto\Bancos\BancoBrasil;

use ArrayObject;
use LogicException;
use Umbrella\Ya\Boleto\AbstractConvenio;
use Umbrella\Ya\Boleto\Bancos\BancoBrasil\Carteira\Carteira21;
use Umbrella\Ya\Boleto\Type\Number;

/**
 * Clase abstrata que representa o Convenio
 * @author italo <italolelis@lellysinformatica.com>
 * @since 1.0.0
 */
class Convenio extends AbstractConvenio
{

    public function gerarCampoLivre(ArrayObject $data)
    {
        $carteira = $this->carteira;

        switch (strlen($this->convenio)) {
            case 4:
                $this->nossoNumero = $this->convenio . $this->getNossoNumero();
                $this->alterarTamanho('CodigoCedente', 4);
                $this->alterarTamanho('NossoNumero', 7);
                $this->layout = ':Banco:Moeda:FatorVencimento:Valor:CodigoCedente:NossoNumero:Agencia:Conta:Carteira';
                break;
            case 6:
                if ($carteira instanceof Carteira21) {
                    $this->alterarTamanho('NossoNumero', 17);
                    $this->layout = ':Banco:Moeda:FatorVencimento:Valor:NossoNumero:Agencia:Conta:Carteira';
                } else {
                    $this->nossoNumero = $this->convenio . Number::modulo11($this->getNossoNumero(), 0, 0, true);
                    $this->alterarTamanho('CodigoCedente', 6);
                    $this->alterarTamanho('NossoNumero', 5);
                    $this->layout = ':Banco:Moeda:FatorVencimento:Valor:CodigoCedente:NossoNumero:Agencia:Conta:Carteira';
                }
                break;
            case 7:
                $this->nossoNumero = $this->convenio . $this->nossoNumero;
                $this->alterarTamanho('CodigoCedente', 7);
                $this->alterarTamanho('NossoNumero', 10);
                $this->layout = ':Banco:Moeda:FatorVencimento:Valor000000:CodigoCedente:NossoNumero:Carteira';
                break;
            default:
                throw new LogicException('O codigo do convenio precisa ter 4, 6 ou 7 digitos!');
        }

        return $data;
    }

}
