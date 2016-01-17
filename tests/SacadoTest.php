<?php namespace Umbrella\YaBoleto\Tests;

use Umbrella\YaBoleto\Cpf;
use Umbrella\YaBoleto\Endereco;
use Umbrella\YaBoleto\PessoaFisica;
use Umbrella\YaBoleto\Sacado;

class SacadoTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Umbrella\YaBoleto\Exception\CpfInvalidoException
     */
    public function testShouldThrownInvalidArgumentException()
    {
        $nomeSacado = "John Doe";
        $documentoSacado = "12112112112";
        $enderecoSacado = new Endereco(
            "Setor de Clubes Esportivos Sul (SCES) - Trecho 2 - Conjunto 31 - Lotes 1A/1B",
            "70200-002",
            "Brasília",
            "DF"
        );
        $pessoaFisica = new PessoaFisica($nomeSacado, new Cpf($documentoSacado), $enderecoSacado);
        $sacado = new Sacado($pessoaFisica);
    }

    /**
     * @see http://www.geradordecpf.org/
     */
    public function testShouldNotThrownInvalidArgumentException()
    {
        $nomeSacado = "John Doe";
        $documentoSacado = "66837381229";
        $enderecoSacado = new Endereco(
            "Setor de Clubes Esportivos Sul (SCES) - Trecho 2 - Conjunto 31 - Lotes 1A/1B",
            "70200-002",
            "Brasília",
            "DF"
        );
        $pessoaFisica = new PessoaFisica($nomeSacado, new Cpf($documentoSacado), $enderecoSacado);
        $sacado = new Sacado($pessoaFisica);
    }

}
