<?php namespace Umbrella\YaBoleto\Tests;

use Umbrella\YaBoleto\Cedente;
use Umbrella\YaBoleto\Cnpj;
use Umbrella\YaBoleto\Cpf;
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
        $enderecoSacado = new Endereco(
            "Setor de Clubes Esportivos Sul (SCES) - Trecho 2 - Conjunto 31 - Lotes 1A/1B",
            "70200-002",
            "Brasília",
            "DF"
        );
        $pessoaFisica = new PessoaFisica("John Doe", new Cpf("09007668404"), $enderecoSacado);
        $sacado = new Sacado($pessoaFisica);

        // cedente...
        $enderecoCedente = new Endereco(
            "Setor de Clubes Esportivos Sul (SCES) - Trecho 2 - Conjunto 31 - Lotes 1A/1B",
            "70200-002",
            "Brasília",
            "DF"
        );
        $cedente = new Cedente(
            "ACME Corporation Inc.",
            new Cnpj("01.122.241/0001-76"),
            $enderecoCedente
        );

        // atribuir e retornar...
        $pessoas = array($sacado, $cedente);

        return $pessoas;
    }
}
