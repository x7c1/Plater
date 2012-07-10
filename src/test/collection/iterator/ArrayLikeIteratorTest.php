<?
use x7c1\plater\collection\iterator\ArrayLikeIterator;

class ArrayLikeIteratorTest extends \PHPUnit_Framework_TestCase{

    public function test_empty(){
        $iter = new ArrayLikeIterator([]);
        $this->assertSame([], $this->iter_to_array($iter));
    }

    public function test_map(){
        $iter = new ArrayLikeIterator([2, 3, 4]);

        $mul = function($x){
            return $x * 2;
        };
        $mul_2 = $this->iter_to_array($iter->map($mul));
        $this->assertSame([4, 6, 8], $mul_2);

        $mul_4 = $this->iter_to_array($iter->map($mul)->map($mul));
        $this->assertSame([8, 12, 16], $mul_4);

        $incr = function($x){
            return $x + 1;
        };
        $incr_then_mul = $iter->map($incr)->map($mul);
        $this->assertSame([6, 8, 10], $this->iter_to_array($incr_then_mul));

        $mul_then_incr = $iter->map($mul)->map($incr);
        $this->assertSame([5, 7, 9], $this->iter_to_array($mul_then_incr));
    }

    public function test_filter(){
        $iter = new ArrayLikeIterator([2, 3, 4, 5]);

        $is_greater = function($x){
            return $x > 2;
        };
        $x = $iter->filter($is_greater);
        $this->assertSame([3, 4, 5], $this->iter_to_array($x));

        $x2 = $x->map(function($i){ return 2 * $i; });
        $this->assertSame([6, 8, 10], $this->iter_to_array($x2));

        $x3 = $x2->filter(function($i){ return $i > 7; });
        $this->assertSame([8, 10], $this->iter_to_array($x3));

        $x4 = $x3->map(function($i){ return ++$i; });
        $this->assertSame([9, 11], $this->iter_to_array($x4));
    }

    private function iter_to_array($iter){
        $array = [];
        foreach($iter as $i => $x){
            $array[] = $x;
        }
        return $array;
    }

}

