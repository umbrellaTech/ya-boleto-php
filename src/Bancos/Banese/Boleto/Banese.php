<?php

namespace Umbrella\YaBoleto\Bancos\Banese\Boleto;

use ArrayObject;
use Umbrella\YaBoleto\AbstractBoleto;
use Umbrella\YaBoleto\Type\Number;
use Umbrella\YaBoleto\Type\StringBuilder;

class Banese extends AbstractBoleto
{
    /**
     * Gera o código de barras, baseado nas informações do banco.
     *
     * @author Victor Felix <victor.dreed@gmail.com>
     * @return string
     */
    protected function gerarCodigoBarras()
    {
        $banco = $this->convenio->getBanco();
        $convenio = $this->convenio;
        $total = $this->getTotal();

        if ($total < 0) {
            throw new \LogicException("Valor total do boleto não pode ser negativo");
        }

        $valor = Number::format($total);

        $data = new ArrayObject(array(
            'Banco' => $banco->getNumero(),
            'Moeda' => $this->moeda,
            'Valor' => $valor,
            'Agencia' => $banco->getAgencia(),
            'Carteira' => $convenio->getCarteira()->getNumero(),
            'Conta' => $banco->getConta(),
            'NossoNumero' => $convenio->getNossoNumero(),
            'FatorVencimento' => Number::fatorVencimento($this->getDataVencimento()),
            'CodigoCedente' => $convenio->getConvenio()
        ));
        $data->setFlags(ArrayObject::ARRAY_AS_PROPS);

        $this->getConvenio()->gerarCampoLivre($data);

        $tamanhos = $convenio->getTamanhos();

        foreach ($data as $var => $value) {
            if (array_key_exists($var, $tamanhos)) {
                $data[$var] = StringBuilder::normalize($data[$var], $tamanhos[$var]);
            }
        }

        //Chamada do método que ajusta o NossoNumero
        $this->getConvenio()->ajustarNossoNumero($data);

        $convenio->setNossoNumero($data['NossoNumero']);

        $chaveAsbace = $banco->getAgencia().$banco->getConta().$convenio->getNossoNumero().$banco->getNumero();
        $primeiroDvAsbace = Number::primeiroDvAsbace($chaveAsbace);
        $segundoDvAsbace = Number::segundoDvAsbace($chaveAsbace, $primeiroDvAsbace);

        $codigoBarras = StringBuilder::insert($convenio->getLayout(), $data);
        $codigoBarras = StringBuilder::putAt($codigoBarras, $primeiroDvAsbace, 41);
        $codigoBarras = StringBuilder::putAt($codigoBarras, $segundoDvAsbace, 42);

        $dv = Number::modulo11($codigoBarras, 1, 1);

        $codigoBarras = StringBuilder::putAt($codigoBarras, $dv, 4);

        return $codigoBarras;
    }
}
