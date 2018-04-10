<?php

namespace Umbrella\YaBoleto\Tests\Sicoob\Boleto;

use Umbrella\YaBoleto\AbstractConvenio;
use Umbrella\YaBoleto\Bancos\Sicoob\Boleto\Sicoob as BoletoSicoob;
use Umbrella\YaBoleto\Bancos\Sicoob\Carteira\Carteira01;
use Umbrella\YaBoleto\Bancos\Sicoob\Convenio;
use Umbrella\YaBoleto\Bancos\Sicoob\Sicoob;
use Umbrella\YaBoleto\Tests\BoletoTestCase;
use Umbrella\YaBoleto\Tests\Mock\Carteira as CarteiraMock;

class BoletoSicoobTest extends BoletoTestCase
{
    protected function bancoProvider()
    {
        return new Sicoob("3263", "210668");
    }

    protected function convenio01Provider()
    {
        $carteira = new Carteira01();

        return new Convenio($this->bancoProvider(), $carteira, "21", "21");
    }

    public function boletoProvider()
    {
        return [
            [$this->pessoasProvider(), $this->convenio01Provider()]
        ];
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

        $bancoNormal = new Sicoob("agenciaTantoFaz", "contaTantoFaz");
        $bancoAngenciaNull = new Sicoob(null, "contaTantoFaz");
        $bancoAngenciaContaNull = new Sicoob(null, null);

        $convenioNormal = new Convenio(
            $bancoNormal,
            $carteiraNormal,
            "convenioTantoFaz",
            "nossoNumeroTantoFaz"
        );

        $convenioAgenciaNull = new Convenio(
            $bancoAngenciaNull,
            $carteiraNormal,
            "convenioTantoFaz",
            "nossoNumeroTantoFaz"
        );

        $convenioAgenciaContaNull = new Convenio(
            $bancoAngenciaContaNull,
            $carteiraNormal,
            "convenioTantoFaz",
            "nossoNumeroTantoFaz"
        );

        $convenioAgenciaContaCarteiraNull = new Convenio(
            $bancoAngenciaContaNull,
            $carteiraNumeroNull,
            "convenioTantoFaz",
            "nossoNumeroTantoFaz"
        );

        return [
            [
                $this->pessoasProvider(),
                $convenioNormal,
                $getMensagemException(["valor"]),
            ],
            [
                $this->pessoasProvider(),
                $convenioAgenciaNull,
                $getMensagemException(["valor", "agencia"]),
            ],
            [
                $this->pessoasProvider(),
                $convenioAgenciaContaNull,
                $getMensagemException(["valor", "agencia", "conta"]),
            ],
            [
                $this->pessoasProvider(),
                $convenioAgenciaContaCarteiraNull,
                $getMensagemException(["valor", "agencia", "conta", "carteira"]),
            ],
        ];
    }

    /**
     * @dataProvider boletoProvider
     */
    public function testShouldCreateBoleto($pessoa, AbstractConvenio $convenio)
    {
        list($sacado, $cedente) = $pessoa;
        $boleto = new BoletoSicoob($sacado, $cedente, $convenio);
        $boleto->setValorDocumento(50)
            ->setNumeroDocumento("024588722")
            ->setDataVencimento(new \DateTime("2018-09-30"))
            ->gerarCodigoBarraLinhaDigitavel();

        $this->assertNotEmpty($boleto);
    }

    /**
     * @dataProvider boletoProvider
     */
    public function testShouldCreateBoletoWithHighValue($pessoa, $convenio)
    {
        list($sacado, $cedente) = $pessoa;
        $boleto = new BoletoSicoob($sacado, $cedente, $convenio);
        $boleto->setValorDocumento("1.500,00")
            ->setNumeroDocumento("23456")
            ->setDataVencimento(new \DateTime("2018-09-30"))
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
        $boleto = new BoletoSicoob($sacado, $cedente, $convenio);
        $boleto->setValorDocumento('-1')
            ->setDesconto(2.00)
            ->setNumeroDocumento("024588722")
            ->setDataVencimento(new \DateTime("2018-09-30"))
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
        $boleto = new BoletoSicoob($sacado, $cedente, $convenio);
        $boleto->setValorDocumento(null);
        $boleto->validarDadosObrigatorios();
        $this->assertNotEmpty($boleto->getErros());
    }

    /**
     * @dataProvider boletoProvider
     */
    public function testShouldValiteSizeOurNumber($pessoa)
    {
        list($sacado, $cedente) = $pessoa;
        $convenio = $this->convenio01Provider();
        $boleto = new BoletoSicoob($sacado, $cedente, $convenio);
        $boleto->setValorDocumento(50)
            ->setNumeroDocumento("024588722")
            ->setDataVencimento(new \DateTime("2018-09-30"))
            ->gerarCodigoBarraLinhaDigitavel();

        $this->assertEquals(8, strlen($boleto->getConvenio()->getNossoNumero()));
    }

    /**
     * @dataProvider boletoProvider
     */
    public function testShouldValiteOurNumberWithDv($pessoa)
    {
        list($sacado, $cedente) = $pessoa;
        $convenio = $this->convenio01Provider();
        $boleto = new BoletoSicoob($sacado, $cedente, $convenio);
        $boleto->setValorDocumento(50)
            ->setNumeroDocumento("024588722")
            ->setDataVencimento(new \DateTime("2018-09-30"))
            ->gerarCodigoBarraLinhaDigitavel();

        $this->assertEquals('00000219', $boleto->getConvenio()->getNossoNumero());
    }
}