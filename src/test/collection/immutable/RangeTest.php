<?
use x7c1\plater\collection\immutable\Range;

class RangeTest extends \PHPUnit_Framework_TestCase{

    public function test_toArray(){
        $range = new Range(3, 10);
        $this->assertSame(range(3, 10), $range->toArray());
    }

    public function test_constructor(){
        try{
            new Range("1");
            $this->fail('InvalidArgumentException not thrown');
        } catch(Exception $e){
            $this->assertTrue($e instanceof InvalidArgumentException);
        }
    }

    public function test_take(){
        $range = new Range(3, 10);
        $this->assertSame([3], $range->take(1)->toArray());
    }

    public function test_iterable_methods(){
        $range = Range::create(3, 10)
            ->map(function($x){ return $x * 2; })
            ->filter(function($x){ return $x > 10; })
            ->take(3);

        $this->assertSame([12, 14, 16], $range->toArray());
    }

    public function test_take_and_evaluation(){
        $counter = 0;
        Range::create(1, 100)
            ->filter(function($x) use(&$counter){ $counter++; return $x % 2; })
            ->take(2)
            ->evaluate(function($x){});

        $this->assertSame(3, $counter);
    }

}

