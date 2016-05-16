<?php namespace Umbrella\YaBoleto\Tests;

use Umbrella\YaBoleto\Endereco;
use Umbrella\YaBoleto\PessoaFisica;
use Umbrella\YaBoleto\Sacado;

class SacadoTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider sacadoProvider
     * @param $nome
     * @param $documento
     * @param Endereco $endereco
     */
    public function testShouldThrownInvalidArgumentException($nome, $documento, Endereco $endereco)
    {
        $documento = "12112112112";
        $pessoaFisica = new PessoaFisica($nome, $documento, $endereco);
        $sacado = new Sacado($pessoaFisica);
    }

    /**
     * @dataProvider sacadoProvider
     * @param $nome
     * @param $documento
     * @param Endereco $endereco
     */
    public function testShouldNotThrownInvalidArgumentException($nome, $documento, Endereco $endereco)
    {
        $pessoaFisica = new PessoaFisica($nome, $documento, $endereco);
        $sacado = new Sacado($pessoaFisica);
    }

    public function sacadoProvider()
    {
        $endereco = new Endereco(
            "Setor de Clubes Esportivos Sul (SCES) - Trecho 2 - Conjunto 31 - Lotes 1A/1B",
            "70200-002",
            "Brasília",
            "DF"
        );

        return [
            ["John Doe", "66837381229", $endereco]
        ];
    }
}
