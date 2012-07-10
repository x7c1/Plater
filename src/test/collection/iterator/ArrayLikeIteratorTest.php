<?
use x7c1\plater\collection\iterator\ArrayLikeIterator;

class ArrayLikeIteratorTest extends \PHPUnit_Framework_TestCase{

    public function test_empty(){
        $iter = new ArrayLikeIterator;
        $this->assertSame([], $iter->toArray());
    }

    public function test_same_result_type(){
        $noop = function(){};
        $iter = new ArrayLikeIterator;
        $this->assertTrue($iter->map($noop)->filter($noop) instanceof ArrayLikeIterator);
    }

    public function test_map(){
        $iter = new ArrayLikeIterator([2, 3, 4]);

        $mul = function($x){ return $x * 2; };
        $this->assertSame([4, 6, 8], $iter->map($mul)->toArray());
        $this->assertSame([8, 12, 16], $iter->map($mul)->map($mul)->toArray());

        $incr = function($x){ return $x + 1; };
        $incr_then_mul = $iter->map($incr)->map($mul);
        $this->assertSame([6, 8, 10], $incr_then_mul->toArray());

        $mul_then_incr = $iter->map($mul)->map($incr);
        $this->assertSame([5, 7, 9], $mul_then_incr->toArray());
    }

    public function test_filter(){
        $iter = new ArrayLikeIterator([2, 3, 4, 5]);

        $is_greater = function($x){ return $x > 2; };
        $x = $iter->filter($is_greater);
        $this->assertSame([3, 4, 5], $x->toArray());

        $x2 = $x->map(function($i){ return 2 * $i; });
        $this->assertSame([6, 8, 10], $x2->toArray());

        $x3 = $x2->filter(function($i){ return $i > 7; });
        $this->assertSame([8, 10], $x3->toArray());

        $x4 = $x3->map(function($i){ return ++$i; });
        $this->assertSame([9, 11], $x4->toArray());
    }

}

