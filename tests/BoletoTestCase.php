<?php namespace Umbrella\YaBoleto\Tests;

use Umbrella\YaBoleto\PessoaFisica;
use Umbrella\YaBoleto\Sacado;
use Umbrella\YaBoleto\Cedente;

class BoletoTestCase extends \PHPUnit_Framework_TestCase
{
    public static function setUpBeforeClass()
    {
        date_default_timezone_set("America/Sao_Paulo");
    }

    protected function pessoasProvider()
    {
        // sacado...
        $nomeSacado      = "John Doe";
        $documentoSacado = "09007668404";
        $enderecoSacado  = array(
            "logradouro" => "Setor de Clubes Esportivos Sul (SCES) - Trecho 2 - Conjunto 31 - Lotes 1A/1B",
            "cep"        => "70200-002",
            "cidade"     => "Brasília",
            "uf"         => "DF"
            );
        $pessoaFisica = new PessoaFisica($nomeSacado, $documentoSacado, $enderecoSacado);
        $sacado       = new Sacado($pessoaFisica);

        // cedente...
        $nomeCedente      = "ACME Corporation Inc.";
        $documentoCedente = "01.122.241/0001-76";
        $enderecoCedente  = array(
            "logradouro" => "Setor de Clubes Esportivos Sul (SCES) - Trecho 2 - Conjunto 31 - Lotes 1A/1B",
            "cep"        => "70200-002",
            "cidade"     => "Brasília",
            "uf"         => "DF"
            );
        $cedente = new Cedente($nomeCedente, $documentoCedente, $enderecoCedente);

        // atribuir e retornar...
        $pessoas = array($sacado, $cedente);
        return $pessoas;
    }

}
