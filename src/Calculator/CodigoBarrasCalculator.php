<?php

namespace Umbrella\YaBoleto\Calculator;

use Umbrella\YaBoleto\AbstractBoleto;
use Umbrella\YaBoleto\CodigoBarras;
use Umbrella\YaBoleto\Type\Number;
use Umbrella\YaBoleto\Type\String;

class CodigoBarrasCalculator implements CodigoBarrasCalulatorInterface
{
    public function calculate(AbstractBoleto $boleto)
    {
        $convenio = $boleto->getConvenio();
        $banco = $convenio->getBanco();
        $total = $boleto->getTotal();

        if ($total < 0) {
            throw new \LogicException("Valor total do boleto não pode ser negativo");
        }

        $valor = Number::format($total);
        $agencia = substr($banco->getAgencia(), 0, 4);
        $conta = substr($banco->getConta(), 0, 4);

        $data = new \ArrayObject([
            'Banco' => $banco->getNumero(),
            'Moeda' => $boleto->getMoeda(),
            'Valor' => $valor,
            'Agencia' => $agencia,
            'Carteira' => $convenio->getCarteira()->getNumero(),
            'Conta' => $conta,
            'NossoNumero' => $convenio->getNossoNumero(),
            'FatorVencimento' => Number::fatorVencimento($boleto->getDataVencimento()),
            'CodigoCedente' => $convenio->getConvenio()
        ]);
        $data->setFlags(\ArrayObject::ARRAY_AS_PROPS);

        $convenio->gerarCampoLivre($data);

        $tamanhos = $convenio->getTamanhos();

        foreach ($data as $var => $value) {
            if (array_key_exists($var, $tamanhos)) {
                $data[$var] = String::normalize($data[$var], $tamanhos[$var]);
            }
        }

        //Chamada do método que ajusta o NossoNumero
        $convenio->ajustarNossoNumero($data);

        $convenio->setNossoNumero($data['NossoNumero']);

        $cod = String::insert($convenio->getLayout(), $data);

        $dv = Number::modulo11($cod, 1, 1);

        return new CodigoBarras(String::putAt($cod, $dv, 4));
    }
}
