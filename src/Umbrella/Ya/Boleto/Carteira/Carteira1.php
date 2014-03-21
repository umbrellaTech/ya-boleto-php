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

namespace Umbrella\Ya\Boleto\Carteira;

/**
 * Representa a carteira 1 (Sem registro) ultilizada para qualquer banco sem carteira
 * @author italo <italolelis@lellysinformatica.com>
 * @since 1.0.0
 */
class Carteira1 implements ICarteira
{

    public $tamanhos = array(
        #Campos comuns a todos os bancos
        'Banco' => 3, //identificação do banco
        'Moeda' => 1, //Código da moeda: real=9
        'DV' => 1, //Dígito verificador geral da linha digitável
        'FatorVencimento' => 4, //Fator de vencimento (Dias passados desde 7/out/1997)
        'Valor' => 10, //Valor nominal do título
        #Campos variávies
        'CodigoCedente' => 6, //Código do cedente
        'NossoNumero' => 17, //Nosso número
    );
    protected $layout = ':Banco:Moeda:FatorVencimento:Valor1:CodigoCedente9:NossoNumero';
    protected $nossoNumero;

    /**
     * inicializa uma instancia da classe Carteira1
     * @param string $nossoNumero
     */
    public function __construct($nossoNumero)
    {
        $this->nossoNumero = $nossoNumero;
    }

    /**
     * {@inheritdoc}
     * @return string
     */
    public function getNossoNumero()
    {
        return $this->nossoNumero;
    }

    /**
     * {@inheritdoc}
     * @param  string                                 $nossoNumero
     * @return \Umbrella\Ya\Boleto\Carteira\ICarteira
     */
    public function setNossoNumero($nossoNumero)
    {
        $this->nossoNumero = $nossoNumero;

        return $this;
    }

    /**
     * {@inheritdoc}
     * @return string
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * {@inheritdoc}
     * @return string
     */
    public function getNumero()
    {
        return "1";
    }

    /**
     * {@inheritdoc}
     * @return array
     */
    public function getTamanhos()
    {
        return $this->tamanhos;
    }

    /**
     * {@inheritdoc}
     * @param \ArrayObject               $data
     * @param \Umbrella\Ya\Boleto\Boleto $boleto
     */
    public function handleData(\ArrayObject $data, \Umbrella\Ya\Boleto\Boleto $boleto)
    {

    }

}
