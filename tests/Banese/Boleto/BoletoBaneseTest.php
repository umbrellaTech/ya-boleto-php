<?php

namespace Umbrella\YaBoleto\Tests\Banese\Boleto;

use Umbrella\YaBoleto\AbstractConvenio;
use Umbrella\YaBoleto\Bancos\Banese\Banese;
use Umbrella\YaBoleto\Bancos\Banese\Boleto\Banese as BoletoBanese;
use Umbrella\YaBoleto\Bancos\Banese\Carteira\CarteiraCE;
use Umbrella\YaBoleto\Bancos\Banese\Convenio;
use Umbrella\YaBoleto\Tests\BoletoTestCase;

class BoletoBaneseTest extends BoletoTestCase
{
    protected function bancoProvider()
    {
        return new Banese("43", "031005046");
    }

    protected function convenioCEProvider()
    {
        $carteira = new CarteiraCE();

        return new Convenio($this->bancoProvider(), $carteira, "00", "00000901");
    }

    public function boletoProvider()
    {
        return [
            [$this->pessoasProvider(), $this->convenioCEProvider()]
        ];
    }

    /**
     * @dataProvider boletoProvider
     */
    public function testShouldCreateBoleto($pessoa, AbstractConvenio $convenio)
    {
        list($sacado, $cedente) = $pessoa;
        $boleto = new BoletoBanese($sacado, $cedente, $convenio);
        $boleto->setValorDocumento(1.00)
            ->setNumeroDocumento(2)
            ->setDataVencimento(new \DateTime("2016-11-02"))
            ->gerarCodigoBarraLinhaDigitavel();

        $this->assertNotEmpty($boleto);
    }

    /**
     * @dataProvider boletoProvider
     */
    public function testShouldCreateBoletoWithHighValue($pessoa, AbstractConvenio $convenio)
    {
        list($sacado, $cedente) = $pessoa;
        $boleto = new BoletoBanese($sacado, $cedente, $convenio);
        $boleto->setValorDocumento("1.500,00")
            ->setNumeroDocumento("23456")
            ->setDataVencimento(new \DateTime("2013-11-02"))
            ->gerarCodigoBarraLinhaDigitavel();

        $this->assertNotEmpty($boleto);
    }

    /**
     * @expectedException \LogicException
     * @dataProvider boletoProvider
     */
    public function testShoudlNotCreateBoletoWithNegativeValue($pessoa, AbstractConvenio $convenio)
    {
        list($sacado, $cedente) = $pessoa;
        $boleto = new BoletoBanese($sacado, $cedente, $convenio);
        $boleto->setValorDocumento(1.00)
            ->setDesconto(2.00)
            ->setNumeroDocumento("024588722")
            ->setDataVencimento(new \DateTime("2013-11-02"))
            ->gerarCodigoBarraLinhaDigitavel();

        $this->assertNotEmpty($boleto);
    }
}