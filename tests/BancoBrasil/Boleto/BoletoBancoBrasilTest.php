<?php namespace Umbrella\YaBoleto\Tests\BancoBrasil\Boleto;

use LogicException;
use Umbrella\YaBoleto\AbstractConvenio;
use Umbrella\YaBoleto\Bancos\BancoBrasil\BancoBrasil;
use Umbrella\YaBoleto\Bancos\BancoBrasil\Boleto\BancoBrasil as BoletoBancoBrasil;
use Umbrella\YaBoleto\Bancos\BancoBrasil\Carteira\Carteira18;
use Umbrella\YaBoleto\Bancos\BancoBrasil\Convenio;
use Umbrella\YaBoleto\Tests\BoletoTestCase;
use Umbrella\YaBoleto\Tests\Mock\Carteira as CarteiraMock;

class BoletoBancoBrasilTest extends BoletoTestCase
{

    protected function bancoProvider()
    {
        return new BancoBrasil("5579-0", "00000-0");
    }

    protected function convenio187Provider()
    {
        $carteira = new Carteira18();

        return new Convenio($this->bancoProvider(), $carteira, "2569589", "2");
    }

    protected function convenio186Provider()
    {
        $carteira = new Carteira18();

        return new Convenio($this->bancoProvider(), $carteira, "164304", "2");
    }

    protected function convenio184Provider()
    {
        $carteira = new Carteira18();

        return new Convenio($this->bancoProvider(), $carteira, "1643", "2");
    }

    public function boletoProvider()
    {
        return array(
            array($this->pessoasProvider(), $this->convenio187Provider()),
            array($this->pessoasProvider(), $this->convenio186Provider()),
            array($this->pessoasProvider(), $this->convenio184Provider())
        );
    }

    public function validatorProvider()
    {
        $getMensagemException = function (array $nomesDosCampos) {
            $dadosFaltantes = implode("', '", $nomesDosCampos);

            return "Faltam dados a serem fornecidos ao boleto. ('{$dadosFaltantes}')";
        };

        $carteiraNormal = new CarteiraMock();
        $carteiraNormal->setNumero(18);

        $carteiraNumeroNull = new CarteiraMock();
        $carteiraNumeroNull->setNumero(null);

        $bancoNormal = new BancoBrasil("agenciaTantoFaz", "contaTantoFaz");
        $bancoAngenciaNull = new BancoBrasil(null, "contaTantoFaz");
        $bancoAngenciaContaNull = new BancoBrasil(null, null);

        $convenioNormal = new Convenio($bancoNormal, $carteiraNormal, "convenioTantoFaz", "nossoNumeroTantoFaz");
        $convenioAgenciaNull = new Convenio($bancoAngenciaNull, $carteiraNormal, "convenioTantoFaz",
            "nossoNumeroTantoFaz");
        $convenioAgenciaContaNull = new Convenio($bancoAngenciaContaNull, $carteiraNormal, "convenioTantoFaz",
            "nossoNumeroTantoFaz");
        $convenioAgenciaContaCarteiraNull = new Convenio($bancoAngenciaContaNull, $carteiraNumeroNull,
            "convenioTantoFaz", "nossoNumeroTantoFaz");

        return array(
            array(
                $this->pessoasProvider(),
                $convenioNormal,
                $getMensagemException(array("valor")),
            ),
            array(
                $this->pessoasProvider(),
                $convenioAgenciaNull,
                $getMensagemException(array("valor", "agencia")),
            ),
            array(
                $this->pessoasProvider(),
                $convenioAgenciaContaNull,
                $getMensagemException(array("valor", "agencia", "conta")),
            ),
            array(
                $this->pessoasProvider(),
                $convenioAgenciaContaCarteiraNull,
                $getMensagemException(array("valor", "agencia", "conta", "carteira")),
            ),
        );
    }

    /**
     * @dataProvider boletoProvider
     */
    public function testShouldCreateBoleto($pessoa, AbstractConvenio $convenio)
    {
        list($sacado, $cedente) = $pessoa;
        $boleto = new BoletoBancoBrasil($sacado, $cedente, $convenio);
        $boleto->setValorDocumento(1.00)
            ->setNumeroDocumento("024588722")
            ->setDataVencimento(new \DateTime("2013-11-02"))
            ->gerarCodigoBarraLinhaDigitavel();

        $this->assertNotEmpty($boleto);
    }

    /**
     * @dataProvider boletoProvider
     */
    public function testShouldCreateBoletoWithHighValue($pessoa, $convenio)
    {
        list($sacado, $cedente) = $pessoa;
        $boleto = new BoletoBancoBrasil($sacado, $cedente, $convenio);
        $boleto->setValorDocumento("1.500,00")
            ->setNumeroDocumento("23456")
            ->setDataVencimento(new \DateTime("2013-11-02"))
            ->gerarCodigoBarraLinhaDigitavel();

        $this->assertNotEmpty($boleto);
    }

    /**
     * @expectedException LogicException
     * @dataProvider boletoProvider
     */
    public function testShoudlNotCreateBoletoWithNegativeValue($pessoa, $convenio)
    {
        list($sacado, $cedente) = $pessoa;
        $boleto = new BoletoBancoBrasil($sacado, $cedente, $convenio);
        $boleto->setValorDocumento(1.00)
            ->setDesconto(2.00)
            ->setNumeroDocumento("024588722")
            ->setDataVencimento(new \DateTime("2013-11-02"))
            ->gerarCodigoBarraLinhaDigitavel();

        $this->assertNotEmpty($boleto);
    }

    /**
     * @dataProvider validatorProvider
     */
    public function testShouldValiteRequiredFields($pessoa, AbstractConvenio $convenio, $mensagem)
    {
        $this->setExpectedException("InvalidArgumentException", $mensagem);
        list($sacado, $cedente) = $pessoa;
        $boleto = new BoletoBancoBrasil($sacado, $cedente, $convenio);
        $boleto->setValorDocumento(null);
        $boleto->validarDadosObrigatorios();
        $this->assertNotEmpty($boleto->getErros());
    }

    /**
     * @dataProvider boletoProvider
     */
    public function testShouldValiteSizeOurNumberConvenioSizeFour($pessoa)
    {
        list($sacado, $cedente) = $pessoa;
        $convenio = $this->convenio184Provider();
        $boleto = new BoletoBancoBrasil($sacado, $cedente, $convenio);
        $boleto->setValorDocumento(1.00)
            ->setNumeroDocumento("024588722")
            ->setDataVencimento(new \DateTime("2013-11-02"))
            ->gerarCodigoBarraLinhaDigitavel();

        $this->assertEquals(11, strlen($boleto->getConvenio()->getNossoNumero()));
    }

    /**
     * @dataProvider boletoProvider
     */
    public function testShouldValiteSizeOurNumberConvenioSizeSix($pessoa)
    {
        list($sacado, $cedente) = $pessoa;
        $convenio = $this->convenio186Provider();
        $boleto = new BoletoBancoBrasil($sacado, $cedente, $convenio);
        $boleto->setValorDocumento(1.00)
            ->setNumeroDocumento("024588722")
            ->setDataVencimento(new \DateTime("2013-11-02"))
            ->gerarCodigoBarraLinhaDigitavel();

        $this->assertEquals(11, strlen($boleto->getConvenio()->getNossoNumero()));
    }

    /**
     * @dataProvider boletoProvider
     */
    public function testShouldValiteSizeOurNumberConvenioSizeSeven($pessoa)
    {
        list($sacado, $cedente) = $pessoa;
        $convenio = $this->convenio187Provider();
        $boleto = new BoletoBancoBrasil($sacado, $cedente, $convenio);
        $boleto->setValorDocumento(1.00)
            ->setNumeroDocumento("024588722")
            ->setDataVencimento(new \DateTime("2013-11-02"))
            ->gerarCodigoBarraLinhaDigitavel();

        $this->assertEquals(17, strlen($boleto->getConvenio()->getNossoNumero()));
    }

}
