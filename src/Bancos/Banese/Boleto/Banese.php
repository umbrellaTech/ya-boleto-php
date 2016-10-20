<?php

namespace Umbrella\YaBoleto\Bancos\Banese\Boleto;

use Umbrella\YaBoleto\AbstractBoleto;
use Umbrella\YaBoleto\Type\Number;
use Umbrella\YaBoleto\Type\StringBuilder;

/**
 * Classe que representa o boleto do Banco do Estado de Sergipe - BANESE
 *
 * @author Victor Felix <victor.dreed@gmail.com>
 * @package Umbrella\YaBoleto\Bancos\Banese\Boleto
 */
class Banese extends AbstractBoleto
{
    /**
     * Retorna a agencia formatada
     *
     * @return string
     */
    protected function getAgenciaFormatada()
    {
        return $this->convenio->getBanco()->getAgencia();
    }

    /**
     * Retorna a conta formatada
     *
     * @return string
     */
    protected function getContaFormatada()
    {
        return $this->convenio->getBanco()->getConta();
    }

    /**
     * Insere os dados do boleto no layout do convênio
     *
     * @param $layout
     * @param $dados
     * @return string
     */
    protected function aplicarDadosAoLayout($layout, $dados)
    {
        $chaveAsbace = $dados['Agencia'] . $dados['Conta'] . $dados['NossoNumero'] . $dados['Banco'];
        $primeiroDvAsbace = Number::primeiroDvAsbace($chaveAsbace);
        $segundoDvAsbace = Number::segundoDvAsbace($chaveAsbace, $primeiroDvAsbace);
        $codigoBarras = StringBuilder::insert($layout, $dados);
        $codigoBarras = $this->inserirDigitoVerificador($codigoBarras, $primeiroDvAsbace, 41);
        $codigoBarras = $this->inserirDigitoVerificador($codigoBarras, $segundoDvAsbace, 42);

        return $codigoBarras;
    }
}
