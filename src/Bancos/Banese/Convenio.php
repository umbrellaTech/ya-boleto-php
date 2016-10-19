<?php

namespace Umbrella\YaBoleto\Bancos\Banese;

use ArrayObject;
use Umbrella\YaBoleto\AbstractConvenio;
use Umbrella\YaBoleto\Type\Number;

class Convenio extends AbstractConvenio
{
    /**
     * Gera o campo livre do código de barras.
     *
     * @author Victor Felix <victor.dreed@gmail.com>
     * @param  ArrayObject $data
     * @return $data
     */
    public function gerarCampoLivre(ArrayObject $data)
    {
        $this->alterarTamanho('Conta', 9);
        $this->alterarTamanho('Agencia', 2);
        $this->layout = ":Banco:Moeda:FatorVencimento:Valor:Agencia:Conta:NossoNumero:Banco";
    }

    /**
     * Ajusta o nosso número
     *
     * @author Victor Felix <victor.dreed@gmail.com>
     * @param ArrayObject $data
     * @return ArrayObject
     */
    public function ajustarNossoNumero(\ArrayObject $data)
    {
        $nossoNumero = "0" . $data['Agencia'] . $data['NossoNumero'];
        $data['NossoNumero'] = substr($nossoNumero, 3, 9) . Number::dvNossoNumeroBanese($nossoNumero);
        return $data;
    }
}