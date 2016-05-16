<?php namespace Umbrella\YaBoleto\Tests;

use Umbrella\YaBoleto\Cedente;
use Umbrella\YaBoleto\Endereco;

class CedenteTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider cedenteProvider
     * @expectedException \InvalidArgumentException
     * @param $nome
     * @param $documento
     * @param Endereco $endereco
     */
    public function testShouldThrownInvalidArgumentException($nome, $documento, Endereco $endereco)
    {
        $documento = "12.121.121/1212-12";
        $cedente = new Cedente($nome, $documento, $endereco);
    }

    /**
     * @dataProvider cedenteProvider
     * @param $nome
     * @param $documento
     * @param Endereco $endereco
     */
    public function testShouldNotThrownInvalidArgumentException($nome, $documento, Endereco $endereco)
    {
        $cedente = new Cedente($nome, $documento, $endereco);
    }

    public function cedenteProvider()
    {
        $endereco = new Endereco(
            "Setor de Clubes Esportivos Sul (SCES) - Trecho 2 - Conjunto 31 - Lotes 1A/1B",
            "70200-002",
            "Brasília",
            "DF"
        );

        return [
            ["ACME Corporation Inc.", "01.122.241/0001-76", $endereco]
        ];
    }
}
