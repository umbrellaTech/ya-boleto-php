<?php namespace Umbrella\YaBoleto\Tests;

use Umbrella\YaBoleto\PessoaFisica;
use Umbrella\YaBoleto\Sacado;

class SacadoTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testShouldThrownInvalidArgumentException()
    {
        $nomeSacado      = "John Doe";
        $documentoSacado = "12112112112";
        $enderecoSacado  = array(
            "logradouro" => "Setor de Clubes Esportivos Sul (SCES) - Trecho 2 - Conjunto 31 - Lotes 1A/1B",
            "cep"        => "70200-002",
            "cidade"     => "Brasília",
            "uf"         => "DF"
            );
        $pessoaFisica = new PessoaFisica($nomeSacado, $documentoSacado, $enderecoSacado);
        $sacado       = new Sacado($pessoaFisica);
    }

    /**
     * @see http://www.geradordecpf.org/
     */
    public function testShouldNotThrownInvalidArgumentException()
    {
        $nomeSacado      = "John Doe";
        $documentoSacado = "66837381229";
        $enderecoSacado  = array(
            "logradouro" => "Setor de Clubes Esportivos Sul (SCES) - Trecho 2 - Conjunto 31 - Lotes 1A/1B",
            "cep"        => "70200-002",
            "cidade"     => "Brasília",
            "uf"         => "DF"
            );
        $pessoaFisica = new PessoaFisica($nomeSacado, $documentoSacado, $enderecoSacado);
        $sacado       = new Sacado($pessoaFisica);
    }

}
