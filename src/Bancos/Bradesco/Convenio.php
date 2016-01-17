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

namespace Umbrella\YaBoleto\Bancos\Bradesco;

use ArrayObject;
use Umbrella\YaBoleto\AbstractConvenio;

/**
 * Classe que representa o convênio do Bradesco.
 *
 * @author  Italo Lelis de Vietro <italolelis@gmail.com>
 * @package YaBoleto
 */
class Convenio extends AbstractConvenio
{
    /**
     * Gera o campo livre do código de barras.
     *
     * @param ArrayObject $data
     * @return ArrayObject $data
     */
    public function gerarCampoLivre(ArrayObject $data)
    {
        $this->alterarTamanho('Agencia', 4);
        $this->alterarTamanho('Carteira', 2);
        $this->alterarTamanho('NossoNumero', 11);
        $this->alterarTamanho('CodigoCedente', 7);

        $this->layout = ':Banco:Moeda:FatorVencimento:Valor:Agencia:Carteira:NossoNumero:CodigoCedente0';

        return $data;
    }

    /**
     * Ajusta o Nosso Numero antes de seta-lo no objeto Convenio.
     *
     * @param ArrayObject $data
     * @return mixed
     */
    public function ajustarNossoNumero(ArrayObject $data)
    {
        return $data['NossoNumero'];
    }
}
