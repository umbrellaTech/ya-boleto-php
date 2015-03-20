<?php namespace Umbrella\YaBoleto\Tests;

use Carbon\Carbon;
use Umbrella\YaBoleto\PessoaFisica;
use Umbrella\YaBoleto\Cedente;
use Umbrella\YaBoleto\Builder\BoletoBuilder;

class BuilderTest extends BoletoTestCase
{
    public function testShouldCreateValidBoletoBradesoWithBuilder()
    {
        // sacado...
        $nomeSacado      = "John Doe";
        $documentoSacado = "090.076.684-04";
        $enderecoSacado  = array(
            "logradouro" => "Setor de Clubes Esportivos Sul (SCES) - Trecho 2 - Conjunto 31 - Lotes 1A/1B",
            "cep"        => "70200-002",
            "cidade"     => "Brasília",
            "uf"         => "DF"
            );

        // cedente...
        $nomeCedente      = "ACME Corporation Inc.";
        $documentoCedente = "01.122.241/0001-76";
        $enderecoCedente  = array(
            "logradouro" => "Setor de Clubes Esportivos Sul (SCES) - Trecho 2 - Conjunto 31 - Lotes 1A/1B",
            "cep"        => "70200-002",
            "cidade"     => "Brasília",
            "uf"         => "DF"
            );

        $builder = new BoletoBuilder(BoletoBuilder::BRADESCO);

        $boleto  = $builder->sacado(BoletoBuilder::PESSOA_FISICA, $nomeSacado, $documentoSacado, $enderecoSacado)
                           ->cedente($nomeCedente, $documentoCedente, $enderecoCedente)
                           ->banco("0564", "0101888")
                           ->carteira("06")
                           ->convenio("0101888", "77000009017")
                           ->build(250, "77000009017", new Carbon("2015-03-24"));

        $this->assertInstanceOf("Umbrella\\YaBoleto\\AbstractBoleto", $boleto);
        $this->assertEquals("23790.56407 67700.000903 17010.188807 8 63770000025000", $boleto->getLinhaDigitavel());
    }
}
