<?php

namespace Umbrella\YaBoleto\Tests\Bradesco\Boleto;

use Umbrella\YaBoleto\AbstractConvenio;
use Umbrella\YaBoleto\Bancos\Bradesco\Boleto\Bradesco as BoletoBradesco;
use Umbrella\YaBoleto\Bancos\Bradesco\Bradesco;
use Umbrella\YaBoleto\Bancos\Bradesco\Carteira\Carteira06;
use Umbrella\YaBoleto\Bancos\Bradesco\Carteira\Carteira09;
use Umbrella\YaBoleto\Bancos\Bradesco\Convenio;
use Umbrella\YaBoleto\Tests\BoletoTestCase;
use Umbrella\YaBoleto\Tests\LinhaDigitavelTrait;
use Umbrella\YaBoleto\Tests\Mock\Carteira as CarteiraMock;

class BoletoBradescoTest extends BoletoTestCase
{
    use LinhaDigitavelTrait;

    protected function bancoProvider()
    {
        return new Bradesco("1101-0", "015776-7");
    }

    protected function convenio06Provider()
    {
        $carteira = new Carteira06();

        return new Convenio($this->bancoProvider(), $carteira, "256945", "2");
    }

    protected function convenio09Provider()
    {
        $carteira = new Carteira09();

        return new Convenio($this->bancoProvider(), $carteira, "256945", "2");
    }

    public function boletoProvider()
    {
        return array(
            array($this->pessoasProvider(), $this->convenio06Provider()),
            array($this->pessoasProvider(), $this->convenio09Provider())
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

        $bancoNormal = new Bradesco("agenciaTantoFaz", "contaTantoFaz");
        $bancoAngenciaNull = new Bradesco(null, "contaTantoFaz");
        $bancoAngenciaContaNull = new Bradesco(null, null);

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
        $boleto = new BoletoBradesco($sacado, $cedente, $convenio);
        $boleto->setValorDocumento(1.00)
            ->setNumeroDocumento("024588722")
            ->setDataVencimento(new \DateTime("2013-11-02"));

        $linhaDigitavel = $this->getLinhaDigitavel($boleto);
        $this->assertNotEmpty($linhaDigitavel);
    }

    /**
     * @dataProvider boletoProvider
     */
    public function testShouldCreateBoletoWithHighValue($pessoa, $convenio)
    {
        list($sacado, $cedente) = $pessoa;
        $boleto = new BoletoBradesco($sacado, $cedente, $convenio);
        $boleto->setValorDocumento("315.500,00")
            ->setNumeroDocumento("23456")
            ->setDataVencimento(new \DateTime("2013-11-02"));

        $linhaDigitavel = $this->getLinhaDigitavel($boleto);
        $this->assertNotEmpty($linhaDigitavel);
    }

    /**
     * @expectedException \LogicException
     * @dataProvider boletoProvider
     */
    public function testShoudlNotCreateBoletoWithNegativeValue($pessoa, $convenio)
    {
        list($sacado, $cedente) = $pessoa;
        $boleto = new BoletoBradesco($sacado, $cedente, $convenio);
        $boleto->setValorDocumento(1.00)
            ->setDesconto(2.00)
            ->setNumeroDocumento("024588722")
            ->setDataVencimento(new \DateTime("2013-11-02"));

        $linhaDigitavel = $this->getLinhaDigitavel($boleto);
        $this->assertNotEmpty($linhaDigitavel);
    }

    /**
     * @dataProvider validatorProvider
     */
    public function testShouldValiteRequiredFields($pessoa, AbstractConvenio $convenio, $mensagem)
    {
        $this->setExpectedException("InvalidArgumentException", $mensagem);
        list($sacado, $cedente) = $pessoa;
        $boleto = new BoletoBradesco($sacado, $cedente, $convenio);
        $boleto->setValorDocumento(null);
        $boleto->validarDadosObrigatorios();
        $this->assertNotEmpty($boleto->getErros());
    }

}
