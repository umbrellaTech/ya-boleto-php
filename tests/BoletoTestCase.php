<?php namespace Umbrella\YaBoleto\Tests;

use Umbrella\YaBoleto\Cedente;
use Umbrella\YaBoleto\Endereco;
use Umbrella\YaBoleto\PessoaFisica;
use Umbrella\YaBoleto\Sacado;

class BoletoTestCase extends \PHPUnit_Framework_TestCase
{
    public static function setUpBeforeClass()
    {
        date_default_timezone_set("America/Sao_Paulo");
    }

    protected function pessoasProvider()
    {
        // sacado...
        $nomeSacado = "John Doe";
        $documentoSacado = "09007668404";
        $enderecoSacado = new Endereco(
            "Setor de Clubes Esportivos Sul (SCES) - Trecho 2 - Conjunto 31 - Lotes 1A/1B",
            "70200-002",
            "Brasília",
            "DF"
        );

        $pessoaFisica = new PessoaFisica($nomeSacado, $documentoSacado, $enderecoSacado);
        $sacado = new Sacado($pessoaFisica);

        // cedente...
        $nomeCedente = "ACME Corporation Inc.";
        $documentoCedente = "01.122.241/0001-76";
        $enderecoCedente = new Endereco(
            "Setor de Clubes Esportivos Sul (SCES) - Trecho 2 - Conjunto 31 - Lotes 1A/1B",
            "70200-002",
            "Brasília",
            "DF"
        );
        $cedente = new Cedente($nomeCedente, $documentoCedente, $enderecoCedente);

        // atribuir e retornar...
        $pessoas = array($sacado, $cedente);

        return $pessoas;
    }

}
