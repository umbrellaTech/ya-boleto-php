<?php namespace Umbrella\YaBoleto\Tests\CaixaEconomica\Boleto;

use Carbon\Carbon;
use Umbrella\YaBoleto\AbstractConvenio;
use Umbrella\YaBoleto\Bancos\CaixaEconomica\Boleto\CaixaEconomica as BoletoCaixaEconomica;
use Umbrella\YaBoleto\Bancos\CaixaEconomica\CaixaEconomica;
use Umbrella\YaBoleto\Bancos\CaixaEconomica\Carteira\CarteiraSicob;
use Umbrella\YaBoleto\Bancos\CaixaEconomica\Carteira\CarteiraSigcb;
use Umbrella\YaBoleto\Bancos\CaixaEconomica\Convenio;
use Umbrella\YaBoleto\Tests\BoletoTestCase;
use Umbrella\YaBoleto\Tests\LinhaDigitavelTrait;
use Umbrella\YaBoleto\Tests\Mock\Carteira as CarteiraMock;

class BoletoCaixaEconomicaTest extends BoletoTestCase
{
    use LinhaDigitavelTrait;

    protected function bancoProvider()
    {
        return new CaixaEconomica("1101-0", "015776-7");
    }

    protected function convenioSigcbProvider()
    {
        $carteira = new CarteiraSigcb();

        return new Convenio($this->bancoProvider(), $carteira, "256945", "2");
    }

    protected function convenioSigobProvider()
    {
        $carteira = new CarteiraSicob();

        return new Convenio($this->bancoProvider(), $carteira, "256945", "2");
    }

    public function boletoProvider()
    {
        return array(
            array($this->pessoasProvider(), $this->convenioSigcbProvider()),
            array($this->pessoasProvider(), $this->convenioSigobProvider()),
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

        $bancoNormal = new CaixaEconomica("agenciaTantoFaz", "contaTantoFaz");
        $bancoAngenciaNull = new CaixaEconomica(null, "contaTantoFaz");
        $bancoAngenciaContaNull = new CaixaEconomica(null, null);

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
        $boleto = new BoletoCaixaEconomica($sacado, $cedente, $convenio);
        $boleto->setValorDocumento(12.50)
            ->setNumeroDocumento("024588722")
            ->setDataVencimento(new Carbon("2014-02-28"));

        $linhaDigitavel = $this->getLinhaDigitavel($boleto);
        $this->assertNotEmpty($linhaDigitavel);
    }

    /**
     * @dataProvider boletoProvider
     */
    public function testShouldCreateBoletoWithHighValue($pessoa, AbstractConvenio $convenio)
    {
        list($sacado, $cedente) = $pessoa;
        $boleto = new BoletoCaixaEconomica($sacado, $cedente, $convenio);
        $boleto->setValorDocumento("315.500,00")
            ->setNumeroDocumento("23456")
            ->setDataVencimento(new Carbon("2013-11-02"));

        $linhaDigitavel = $this->getLinhaDigitavel($boleto);
        $this->assertNotEmpty($linhaDigitavel);
    }

    /**
     * @expectedException \LogicException
     * @dataProvider boletoProvider
     */
    public function testShoudlNotCreateBoletoWithNegativeValue($pessoa, AbstractConvenio $convenio)
    {
        list($sacado, $cedente) = $pessoa;
        $boleto = new BoletoCaixaEconomica($sacado, $cedente, $convenio);
        $boleto->setValorDocumento(1.00)
            ->setDesconto(2.00)
            ->setNumeroDocumento("024588722")
            ->setDataVencimento(new Carbon("2013-11-02"));

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
        $boleto = new BoletoCaixaEconomica($sacado, $cedente, $convenio);
        $boleto->setValorDocumento(null);
        $boleto->validarDadosObrigatorios();
        $this->assertNotEmpty($boleto->getErros());
    }
}
