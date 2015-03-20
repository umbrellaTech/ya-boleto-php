<?php namespace Umbrella\YaBoleto\Tests;

use Umbrella\YaBoleto\Cedente;

class CedenteTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testShouldThrownInvalidArgumentException()
    {
        $nomeCedente      = "ACME Corporation Inc.";
        $documentoCedente = "12.121.121/1212-12";
        $enderecoCedente  = array(
            "logradouro" => "Setor de Clubes Esportivos Sul (SCES) - Trecho 2 - Conjunto 31 - Lotes 1A/1B",
            "cep"        => "70200-002",
            "cidade"     => "Brasília",
            "uf"         => "DF"
            );

        $cedente = new Cedente($nomeCedente, $documentoCedente, $enderecoCedente);
    }

    /**
     * @see http://www.geradordecpf.org/
     */
    public function testShouldNotThrownInvalidArgumentException()
    {
        $nomeCedente      = "ACME Corporation Inc.";
        $documentoCedente = "01.122.241/0001-76";
        $enderecoCedente  = array(
            "logradouro" => "Setor de Clubes Esportivos Sul (SCES) - Trecho 2 - Conjunto 31 - Lotes 1A/1B",
            "cep"        => "70200-002",
            "cidade"     => "Brasília",
            "uf"         => "DF"
            );

        $cedente = new Cedente($nomeCedente, $documentoCedente, $enderecoCedente);
    }

}
