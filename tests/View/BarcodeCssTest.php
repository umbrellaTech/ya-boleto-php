<?php

namespace Umbrella\YaBoleto\Tests;

use Umbrella\YaBoleto\CodigoBarras;
use Umbrella\YaBoleto\View\Helper\BarcodeCss;

class BarcodeCssTest extends BoletoTestCase
{
    public function testShouldRenderCssStyle()
    {
        $barcodeNumber = "123456";
        $barcode = new CodigoBarras($barcodeNumber);
        $render = new BarcodeCss();
        $this->assertEquals(
            "<div class='barcode'><div class='black thin'></div><div class='white thin'></div><div class='black thin'></div><div class='white thin'></div><div class='black large'></div><div class='white thin'></div><div class='black thin'></div><div class='white large'></div><div class='black thin'></div><div class='white thin'></div><div class='black thin'></div><div class='white thin'></div><div class='black large'></div><div class='white large'></div><div class='black large'></div><div class='white thin'></div><div class='black large'></div><div class='white thin'></div><div class='black thin'></div><div class='white large'></div><div class='black thin'></div><div class='white thin'></div><div class='black thin'></div><div class='white large'></div><div class='black large'></div><div class='white thin'></div><div class='black thin'></div><div class='white large'></div><div class='black large'></div><div class='white large'></div><div class='black thin'></div><div class='white thin'></div><div class='black thin'></div><div class='white thin'></div><div class='black thin'></div><div class='white thin'></div><div class='black thin'></div></div>",
            $render->render($barcode)
        );
    }
}
