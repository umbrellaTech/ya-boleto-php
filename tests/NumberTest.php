<?php
namespace Umbrella\YaBoleto\Tests;

use Umbrella\YaBoleto\Type\Number;


class NumberTest  extends \PHPUnit_Framework_TestCase
{

    public function testModulo11(){
        $this->assertEquals(7, Number::modulo11("11327600026"));
    }


}