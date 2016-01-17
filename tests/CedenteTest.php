<?php

namespace Umbrella\YaBoleto\Tests;

use Umbrella\YaBoleto\Cedente;
use Umbrella\YaBoleto\Cnpj;
use Umbrella\YaBoleto\Endereco;

class CedenteTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Umbrella\YaBoleto\Exception\CnpjInvalidoException
     */
    public function testShouldThrownInvalidArgumentException()
    {
        $nomeCedente = "ACME Corporation Inc.";
        $documentoCedente = "12.121.121/1212-12";
        $enderecoCedente = new Endereco(
            "Setor de Clubes Esportivos Sul (SCES) - Trecho 2 - Conjunto 31 - Lotes 1A/1B",
            "70200-002",
            "Brasília",
            "DF"
        );

        $cedente = new Cedente($nomeCedente, new Cnpj($documentoCedente), $enderecoCedente);
    }

    /**
     * @see http://www.geradordecpf.org/
     */
    public function testShouldNotThrownInvalidArgumentException()
    {
        $nomeCedente = "ACME Corporation Inc.";
        $documentoCedente = "01.122.241/0001-76";
        $enderecoCedente = new Endereco(
            "Setor de Clubes Esportivos Sul (SCES) - Trecho 2 - Conjunto 31 - Lotes 1A/1B",
            "70200-002",
            "Brasília",
            "DF"
        );

        $cedente = new Cedente($nomeCedente, new Cnpj($documentoCedente), $enderecoCedente);
    }

}
