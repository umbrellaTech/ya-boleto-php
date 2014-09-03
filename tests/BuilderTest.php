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

use DateTime;
use Umbrella\Ya\Boleto\Builder\Bancos;
use Umbrella\Ya\Boleto\Builder\BoletoBuilder;

/**
 * Description of CedenteTest
 *
 * @author italo
 */
class BuilderTest extends BoletoTestCase
{

    public function testValidarBuilder()
    {
        $builder = new BoletoBuilder(Bancos::BANCO_BRASIL);

        $boleto = $builder
            ->sacado('Sacado', '61670634787') // também pode ser passado com a máscara 616.706.347-87
            ->cedente('Cendente', '08365691000139') // também pode ser passado com a máscara 08.365.691/0001-39
            ->banco(1234, 123456787)
            ->carteira(18)
            ->convenio(1234567, 2)
            ->build(50, 2, new DateTime('2014-09-02'));

        $this->assertInstanceOf('Umbrella\\Ya\\Boleto\\Boleto', $boleto);
        $this->assertEquals('00190.00009 01234.567004 00000.002188 7 61740000005000', $boleto->getLinhaDigitavel());
    }
}
