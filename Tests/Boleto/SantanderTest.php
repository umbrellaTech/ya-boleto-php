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

namespace Umbrella\Ya\Boleto\Tests\Boleto;

/**
 * Description of BoletoBancoBrasilTest
 *
 * @author italo
 */
class SantanderTest extends BoletoTestCase
{

    protected function bancoProvider()
    {
        $banco = new \Umbrella\Ya\Boleto\Santander\Santander("3857", "6188974");
        $banco->setIos(0);
        return $banco;
    }

    protected function convenio102Provider()
    {
        $carteira = new \Umbrella\Ya\Boleto\Santander\Carteira\Carteira102();
        return new \Umbrella\Ya\Boleto\Santander\Convenio($this->bancoProvider(), $carteira, "0033418619006188974", "2");
    }

    public function boletoProvider()
    {
        return array(array($this->pessoaProvider(), $this->convenio102Provider()));
    }

    /**
     * @dataProvider boletoProvider
     */
    public function testCriacaoBoletoComBanco($pessoa, $convenio)
    {
        $boleto = new \Umbrella\Ya\Boleto\Santander\Boleto\Santander($pessoa[0], $pessoa[1], $convenio);
        $boleto->setValorDocumento(1.00)
                ->setNumeroDocumento("024588722")
                ->setDataVencimento(new \DateTime("2013-11-02"))
                ->getLinhaDigitavel();

        $this->assertNotEmpty($boleto);
    }

    /**
     * @dataProvider boletoProvider
     */
    public function testBoletoComValorAlto($pessoa, $convenio)
    {
        $boleto = new \Umbrella\Ya\Boleto\Santander\Boleto\Santander($pessoa[0], $pessoa[1], $convenio);
        $boleto->setValorDocumento("1.500,00")
                ->setNumeroDocumento("23456")
                ->setDataVencimento(new \DateTime("2013-11-02"))
                ->getLinhaDigitavel();

        $this->assertNotEmpty($boleto);
    }

    /**
     * @expectedException \LogicException 
     * @dataProvider boletoProvider
     */
    public function testValorNegativo($pessoa, $convenio)
    {
        $boleto = new \Umbrella\Ya\Boleto\Santander\Boleto\Santander($pessoa[0], $pessoa[1], $convenio);
        $boleto->setValorDocumento(1.00)
                ->setDesconto(2.00)
                ->setNumeroDocumento("024588722")
                ->setDataVencimento(new \DateTime("2013-11-02"))
                ->getLinhaDigitavel();

        $this->assertNotEmpty($boleto);
    }

}
