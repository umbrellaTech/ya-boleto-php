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

namespace Umbrella\Ya\Boleto\Tests;

/**
 * Description of BoletoBancoBrasilTest
 *
 * @author italo
 */
class BoletoBancoBrasilTest extends \PHPUnit_Framework_TestCase
{

    public function testCriacaoBoletoComBanco()
    {
        date_default_timezone_set("America/Recife");
        $banco = new \Umbrella\Ya\Boleto\Banco\BancoBrasil("5579-0", "00000-0");
        $carteira = new \Umbrella\Ya\Boleto\Carteira\Carteira187("2");
        $convenio = new \Umbrella\Ya\Boleto\Convenio($banco, $carteira, "2569589685");

        $pf = new \Umbrella\Ya\Boleto\PessoaFisica("Sacado 01", "09007668404");
        $sacado = new \Umbrella\Ya\Boleto\Sacado($pf);
        $cedente = new \Umbrella\Ya\Boleto\Cedente("Cendente 01", "92.559.708/0001-03");

        $boleto = new \Umbrella\Ya\Boleto\Boleto\BancoBrasil($sacado, $cedente, $convenio);
        $boleto->setValorDocumento(1.00)
                ->setNumeroDocumento("024588722")
                ->setDataVencimento(new \DateTime("2013-11-02"))
                ->getLinhaDigitavel();

        $this->assertNotEmpty($boleto);
    }

    public function testBoletoComValorAlto()
    {
        date_default_timezone_set("America/Recife");
        $banco = new \Umbrella\Ya\Boleto\Banco\BancoBrasil("1234-5", "1234567-8");
        $carteira = new \Umbrella\Ya\Boleto\Carteira\Carteira187("12345678");
        $convenio = new \Umbrella\Ya\Boleto\Convenio($banco, $carteira, "123456");

        $pf = new \Umbrella\Ya\Boleto\PessoaFisica("Sacado 01", "09007668404");
        $sacado = new \Umbrella\Ya\Boleto\Sacado($pf);
        $cedente = new \Umbrella\Ya\Boleto\Cedente("Cendente 01", "92.559.708/0001-03");

        $boleto = new \Umbrella\Ya\Boleto\Boleto\BancoBrasil($sacado, $cedente, $convenio);
        $boleto->setValorDocumento("1.500,00")
                ->setNumeroDocumento("23456")
                ->setDataVencimento(new \DateTime("2013-11-02"))
                ->getLinhaDigitavel();
    }

    /**
     * @expectedException \LogicException 
     */
    public function testValorNegativo()
    {
        date_default_timezone_set("America/Recife");
        $banco = new \Umbrella\Ya\Boleto\Banco\BancoBrasil("5579-0", "00000-0");
        $carteira = new \Umbrella\Ya\Boleto\Carteira\Carteira187("2");
        $convenio = new \Umbrella\Ya\Boleto\Convenio($banco, $carteira, "2569589685");

        $pf = new \Umbrella\Ya\Boleto\PessoaFisica("Sacado 01", "09007668404");
        $sacado = new \Umbrella\Ya\Boleto\Sacado($pf);
        $cedente = new \Umbrella\Ya\Boleto\Cedente("Cendente 01", "92.559.708/0001-03");

        $boleto = new \Umbrella\Ya\Boleto\Boleto\BancoBrasil($sacado, $cedente, $convenio);
        $boleto->setValorDocumento(1.00)
                ->setDesconto(2.00)
                ->setNumeroDocumento("024588722")
                ->setDataVencimento(new \DateTime("2013-11-02"))
                ->getLinhaDigitavel();

        $this->assertNotEmpty($boleto);
    }

    public function testConvenio6()
    {
        date_default_timezone_set("America/Recife");
        $banco = new \Umbrella\Ya\Boleto\Banco\BancoBrasil("1234-5", "1234567-8");
        $carteira = new \Umbrella\Ya\Boleto\Carteira\Carteira187("12345678");
        $convenio = new \Umbrella\Ya\Boleto\Convenio($banco, $carteira, "123456");

        $pf = new \Umbrella\Ya\Boleto\PessoaFisica("Sacado 01", "09007668404");
        $sacado = new \Umbrella\Ya\Boleto\Sacado($pf);
        $cedente = new \Umbrella\Ya\Boleto\Cedente("Cendente 01", "92.559.708/0001-03");

        $boleto = new \Umbrella\Ya\Boleto\Boleto\BancoBrasil($sacado, $cedente, $convenio);
        $boleto->setValorDocumento("1.500,00")
                ->setNumeroDocumento("23456")
                ->setDataVencimento(new \DateTime("2013-11-02"))
                ->getLinhaDigitavel();
    }

}
