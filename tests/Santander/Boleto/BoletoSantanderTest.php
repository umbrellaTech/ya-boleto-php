<?php namespace Umbrella\YaBoleto\Tests\Santander\Boleto;

use Carbon\Carbon;
use Umbrella\YaBoleto\AbstractConvenio;
use Umbrella\YaBoleto\Bancos\Santander\Boleto\Santander as BoletoSantander;
use Umbrella\YaBoleto\Bancos\Santander\Carteira\Carteira101;
use Umbrella\YaBoleto\Bancos\Santander\Carteira\Carteira102;
use Umbrella\YaBoleto\Bancos\Santander\Carteira\Carteira201;
use Umbrella\YaBoleto\Bancos\Santander\Carteira\Carteira57;
use Umbrella\YaBoleto\Bancos\Santander\Convenio;
use Umbrella\YaBoleto\Bancos\Santander\Santander;
use Umbrella\YaBoleto\Tests\BoletoTestCase;
use Umbrella\YaBoleto\Tests\LinhaDigitavelTrait;

class BoletoSantanderTest extends BoletoTestCase
{
    use LinhaDigitavelTrait;

    protected function bancoProvider()
    {
        $banco = new Santander("3857", "6188974");
        $banco->setIos(0);

        return $banco;
    }

    protected function convenio57Provider()
    {
        $carteira = new Carteira57();

        return new Convenio($this->bancoProvider(), $carteira, "0033418619006188974", "2");
    }

    protected function convenio201Provider()
    {
        $carteira = new Carteira201();

        return new Convenio($this->bancoProvider(), $carteira, "0033418619006188974", "2");
    }

    protected function convenio102Provider()
    {
        $carteira = new Carteira102();

        return new Convenio($this->bancoProvider(), $carteira, "0033418619006188974", "2");
    }

    protected function convenio101Provider()
    {
        $carteira = new Carteira101();

        return new Convenio($this->bancoProvider(), $carteira, "0033418619006188974", "2");
    }

    public function boletoProvider()
    {
        return array(
            array($this->pessoasProvider(), $this->convenio57Provider()),
            array($this->pessoasProvider(), $this->convenio201Provider()),
            array($this->pessoasProvider(), $this->convenio102Provider()),
            array($this->pessoasProvider(), $this->convenio101Provider())
        );
    }

    /**
     * @dataProvider boletoProvider
     */
    public function testShouldCreateBoleto($pessoa, AbstractConvenio $convenio)
    {
        list($sacado, $cedente) = $pessoa;
        $boleto = new BoletoSantander($sacado, $cedente, $convenio);
        $boleto->setValorDocumento(1.00)
            ->setNumeroDocumento("024588722")
            ->setDataVencimento(new Carbon("2013-11-02"));

        $linhaDigitavel = $this->getLinhaDigitavel($boleto);
        $this->assertNotEmpty($linhaDigitavel);
    }

    /**
     * @dataProvider boletoProvider
     */
    public function testShouldCreateBoletoWithHighValue($pessoa, AbstractConvenio $convenio)
    {
        list($sacado, $cedente) = $pessoa;
        $boleto = new BoletoSantander($sacado, $cedente, $convenio);
        $boleto->setValorDocumento("1.500,00")
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
        $boleto = new BoletoSantander($sacado, $cedente, $convenio);
        $boleto->setValorDocumento(1.00)
            ->setDesconto(2.00)
            ->setNumeroDocumento("024588722")
            ->setDataVencimento(new Carbon("2013-11-02"));

        $linhaDigitavel = $this->getLinhaDigitavel($boleto);
        $this->assertNotEmpty($linhaDigitavel);
    }

}
