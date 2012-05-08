<?
//namespace x7c1\plater\collection\iterator;

use x7c1\plater\collection\iterator\Xc_Iterator;

class Xc_IteratorTest extends \PHPUnit_Framework_TestCase{

    public function test_sample(){
        $iter = new Xc_Iterator;
        $this->assertSame(1, $iter->sample);
        $this->assertNotSame(2, $iter->sample);
    }

}

