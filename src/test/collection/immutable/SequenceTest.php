<?
use x7c1\plater\collection\immutable\Sequence;

class SequenceTest extends \PHPUnit_Framework_TestCase{

    public function test_internal_pointer(){
        $seq = new Sequence([1,2]);
        $result = [];
        foreach($seq as $i){
            foreach($seq as $i)
                $result[] = $i;
        }
        $this->assertSame([1,2,1,2], $result);
    }

    public function test_internal_pointer_after_higher_order_functions(){
        $seq = new Sequence([1,2,3]);
        $seq = $seq
            ->map(function($x){return $x * 2;})
            ->filter(function($x){return $x > 2;});

        $result = [];
        foreach($seq as $i){
            foreach($seq as $i)
                $result[] = $i;
        }
        $this->assertSame([4,6,4,6], $result);
    }

    public function test_empty(){
        $seq = new Sequence;
        $this->assertSame([], $seq->toArray());
    }

    public function test_same_result_type(){
        $noop = function(){};
        $seq = new Sequence;
        $this->assertTrue($seq->map($noop)->filter($noop) instanceof Sequence);
    }

    public function test_map(){
        $seq = new Sequence([2, 3, 4]);

        $mul = function($x){ return $x * 2; };
        $this->assertSame([4, 6, 8], $seq->map($mul)->toArray());
        $this->assertSame([8, 12, 16], $seq->map($mul)->map($mul)->toArray());

        $incr = function($x){ return $x + 1; };
        $incr_then_mul = $seq->map($incr)->map($mul);
        $this->assertSame([6, 8, 10], $incr_then_mul->toArray());

        $mul_then_incr = $seq->map($mul)->map($incr);
        $this->assertSame([5, 7, 9], $mul_then_incr->toArray());
    }

    public function test_filter(){
        $seq = new Sequence([2, 3, 4, 5]);

        $is_greater = function($x){ return $x > 2; };
        $x = $seq->filter($is_greater);
        $this->assertSame([3, 4, 5], $x->toArray());

        $x2 = $x->map(function($i){ return 2 * $i; });
        $this->assertSame([6, 8, 10], $x2->toArray());

        $x3 = $x2->filter(function($i){ return $i > 7; });
        $this->assertSame([8, 10], $x3->toArray());

        $x4 = $x3->map(function($i){ return ++$i; });
        $this->assertSame([9, 11], $x4->toArray());
    }

    public function test_take(){
        $seq = new Sequence([2, 3, 4, 5, 6]);

        $take2 = $seq->take(4);
        $this->assertSame([2, 3, 4, 5], $take2->toArray());

        $take3 = $take2->filter(function($x){return $x > 2;});
        $this->assertSame([3, 4, 5], $take3->toArray());

        $take4 = $take3->map(function($x){return $x * 2;})->take(2);
        $this->assertSame([6, 8], $take4->toArray());
    }

    public function test_drop(){
        $seq = new Sequence([2, 3, 4, 5, 6]);
        $dropped = $seq->drop(2);
        $this->assertSame([4, 5, 6], $dropped->toArray());

        $dropped2 = $dropped->drop(1);
        $this->assertSame([5, 6], $dropped2->toArray());

        //confirm a same result after the second call
        $this->assertSame([5, 6], $dropped2->toArray());
    }

    public function test_take_and_drop(){
        $counter = 0;
        $list = [];
        Sequence::create([1, 2, 3, 4, 5, 6])
            ->filter(function($x) use(&$counter){ $counter++; return true; })
            ->take(2)
            ->drop(2)
            ->evaluate(function($x) use(&$list){ $list[]=$x; });

        $this->assertSame(2, $counter);
        $this->assertSame([], $list);
    }

    public function test_drop_and_take(){
        $counter = 0;
        $list = [];
        Sequence::create([1, 2, 3, 4, 5, 6])
            ->filter(function($x) use(&$counter){ $counter++; return true; })
            ->drop(2)
            ->take(2)
            ->evaluate(function($x) use(&$list){ $list[]=$x; });

        $this->assertSame(4, $counter);
        $this->assertSame([3, 4], $list);
    }

    public function test_drop_and_evaluation(){
        $counter = 0;
        Sequence::create([1, 2, 3, 4, 5, 6])
            ->filter(function($x) use(&$counter){ $counter++; return true; })
            ->drop(2)
            ->evaluate(function($x){});

        $this->assertSame(6, $counter);
    }

    public function test_splitAt(){
        $seq = new Sequence([2, 3, 4, 5, 6, 7]);
        list($left, $right) = $seq->splitAt(3);
        $this->assertSame([2, 3, 4], $left->toArray());
        $this->assertSame([5, 6, 7], $right->toArray());
    }

    public function test_slice(){
        $seq = new Sequence([2, 3, 4, 5, 6, 7]);
        $sliced = $seq->slice(2, 5);
        $this->assertSame([4, 5, 6], $sliced->toArray());

        $this->assertSame([], $sliced->slice(10, 20)->toArray());
        $this->assertSame([4, 5, 6], $sliced->slice(0, 20)->toArray());
    }
}

