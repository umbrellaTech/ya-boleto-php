<?php

namespace Umbrella\YaBoleto\Tests;

use Umbrella\YaBoleto\CodigoBarras;
use Umbrella\YaBoleto\View\Helper\BarcodeFont;

class BarcodeFontTest extends BoletoTestCase
{
    public function testShouldRenderFontStyle()
    {
        $barcodeNumber = "123456";
        $barcode = new CodigoBarras($barcodeNumber);
        $render = new BarcodeFont();
        $this->assertEquals($barcodeNumber, $render->render($barcode));
    }
}
