<?php


namespace Umbrella\Ya\Boleto;

/**
 * Contem as funcionalidades basicas para uma carteira
 * @author italo <italolelis@lellysinformatica.com>
 * @since 1.0.0
 */
interface ConvenioInterface
{

    /**
     * Retorna o layout do codigo de barras
     * @return string
     */
    public function getLayout();

    /**
     * @return AbstractConvenio
     */
    public function setLayout($layout);

    /**
     * Retorna o nosso numero
     * @return string
     */
    public function getNossoNumero();

    /**
     * Define o nosso numero
     * @param  string                                 $nossoNumero
     * @return \Umbrella\Ya\Boleto\Carteira\CarteiraInterface
     */
    public function setNossoNumero($nossoNumero);

    /**
     * Retorna os padroes de tamanhos para calculo do codigo de barras
     * @return string
     */
    public function getTamanhos();

    /**
     * Altera o valor de uma composiao dos tamanhos da carteira
     * @return void
     */
    public function alterarTamanho($index, $tamanho);
}
