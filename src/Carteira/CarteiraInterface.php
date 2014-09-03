<?php

namespace Umbrella\Ya\Boleto\Carteira;

/**
 * Contem as funcionalidades basicas para uma carteira
 * @author italo <italolelis@lellysinformatica.com>
 * @since 1.0.0
 */
interface CarteiraInterface
{

    /**
     * Retorna o numero da carteira
     * @return string
     */
    public function getNumero();
}
