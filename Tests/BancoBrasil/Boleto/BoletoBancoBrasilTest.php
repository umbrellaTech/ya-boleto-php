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

namespace Umbrella\Ya\Boleto\Tests\BancoBrasil\Boleto;

use DateTime;
use LogicException;
use Umbrella\Ya\Boleto\BancoBrasil\Carteira\Carteira18;
use Umbrella\Ya\Boleto\BancoBrasil\Convenio;
use Umbrella\Ya\Boleto\Tests\BoletoTestCase;
use Umbrella\Ya\Boleto\BancoBrasil\Boleto\BancoBrasil as BoletoBancoBrasil;

/**
 * Description of BoletoBancoBrasilTest
 *
 * @author italo
 */
class BoletoBancoBrasilTest extends BoletoTestCase
{

    protected function bancoProvider()
    {
        return new \Umbrella\Ya\Boleto\BancoBrasil\BancoBrasil("5579-0", "00000-0");
    }

    protected function convenio187Provider()
    {
        $carteira = new Carteira18();
        return new Convenio($this->bancoProvider(), $carteira, "2569589", "2");
    }

    protected function convenio186Provider()
    {
        $carteira = new Carteira18();
        return new Convenio($this->bancoProvider(), $carteira, "1643044", "2");
    }

    protected function convenio184Provider()
    {
        $carteira = new Carteira18();
        return new Convenio($this->bancoProvider(), $carteira, "1643", "2");
    }

    public function boletoProvider()
    {
        return array(
            array($this->pessoaProvider(), $this->convenio187Provider()),
            array($this->pessoaProvider(), $this->convenio186Provider()),
            array($this->pessoaProvider(), $this->convenio184Provider())
        );
    }

    /**
     * @dataProvider boletoProvider
     */
    public function testCriacaoBoletoComBanco($pessoa, $convenio)
    {
        $boleto = new BoletoBancoBrasil($pessoa[0], $pessoa[1], $convenio);
        $boleto->setValorDocumento(1.00)
                ->setNumeroDocumento("024588722")
                ->setDataVencimento(new DateTime("2013-11-02"))
                ->getLinhaDigitavel();

        $this->assertNotEmpty($boleto);
    }

    /**
     * @dataProvider boletoProvider
     */
    public function testBoletoComValorAlto($pessoa, $convenio)
    {
        $boleto = new BoletoBancoBrasil($pessoa[0], $pessoa[1], $convenio);
        $boleto->setValorDocumento("1.500,00")
                ->setNumeroDocumento("23456")
                ->setDataVencimento(new DateTime("2013-11-02"))
                ->getLinhaDigitavel();

        $this->assertNotEmpty($boleto);
    }

    /**
     * @expectedException LogicException 
     * @dataProvider boletoProvider
     */
    public function testValorNegativo($pessoa, $convenio)
    {
        $boleto = new BoletoBancoBrasil($pessoa[0], $pessoa[1], $convenio);
        $boleto->setValorDocumento(1.00)
                ->setDesconto(2.00)
                ->setNumeroDocumento("024588722")
                ->setDataVencimento(new DateTime("2013-11-02"))
                ->getLinhaDigitavel();

        $this->assertNotEmpty($boleto);
    }

    /**
     * @dataProvider boletoProvider
     */
    public function testValidarCamposObrigatorios($pessoa, $convenio)
    {
        $boleto = new BoletoBancoBrasil($pessoa[0], $pessoa[1], $convenio);
        $boleto->setValorDocumento("1.500,00")
                ->setNumeroDocumento("23456")
                ->setDataVencimento(new DateTime("2013-11-02"))
                ->getLinhaDigitavel();

        $this->assertNotEmpty($boleto);
    }

}
