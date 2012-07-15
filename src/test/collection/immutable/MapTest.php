<?
use x7c1\plater\collection\immutable\Map;

class MapTest extends \PHPUnit_Framework_TestCase{

    public function test_internal_pointer(){
        $map = new Map(['a' => 1, 'b' => 2]);
        $result = [];
        foreach($map as $i){
            foreach($map as $i)
                $result[] = $i;
        }
        $this->assertSame([1,2,1,2], $result);
    }

    public function test_internal_pointer_after_higher_functions(){
        $map = new Map(['a' => 1, 'b' => 2, 'c' => 3]);
        $map = $map
            ->map(function($x){return $x * 2;})
            ->filter(function($x){return $x > 2;});

        $result = [];
        foreach($map as $i){
            foreach($map as $i)
                $result[] = $i;
        }
        $this->assertSame([4,6,4,6], $result);
    }

    public function test_has(){
        $map = new Map([
            'a' => 11,
            'b' => 22,
        ]);
        $this->assertTrue($map->has('a'));
        $this->assertFalse($map->has('c'));
    }

    public function test_getOr(){
        $map = new Map([
            'a' => 11,
            'b' => 22,
        ]);
        $this->assertSame(11, $map->getOr('a', 100));
        $this->assertSame(200, $map->getOr('c', 200));
    }

    public function test_filter_key(){
        $map = new Map([
            'a' => 11,
            'b' => 22,
        ]);
        $iter = $map->filter(function($_, $key){ return $key === 'a' ; });
        $this->assertSame(['a' => 11], $iter->toArray());
        $this->assertTrue($iter->has('a'));
        $this->assertFalse($iter->has('b'));
    }

    public function test_filter_value(){
        $map = new Map([
            'a' => 11,
            'b' => 22,
        ]);
        $iter = $map->filter(function($value){ return $value > 20; });
        $this->assertSame(['b' => 22], $iter->toArray());
        $this->assertTrue($iter->has('b'));
        $this->assertFalse($iter->has('a'));
    }

    public function test_map(){
        $map = new Map([
            'a' => 11,
            'b' => 22,
        ]);
        $iter = $map->map(function($value){ return $value * 2; });
        $this->assertSame(['a' => 22, 'b' => 44], $iter->toArray());
        $this->assertSame(44, $iter->getOr('b', 55));
        $this->assertSame(123, $iter->getOr('c', 123));
    }

    public function test_keys_and_values(){
        $map = new Map([
            'a' => 11,
            'b' => 22,
        ]);
        $this->assertSame(['a', 'b'], $map->keys());
        $this->assertSame([11, 22], $map->values());
    }

    public function test_take(){
        $map = new Map([
            'a' => 11,
            'b' => 22,
            'c' => 33,
        ]);
        $this->assertSame([], $map->take(0)->toArray());
        $this->assertSame(['a' => 11], $map->take(1)->toArray());

        $filtered = $map->filter(function($x){ return $x > 11; });
        $this->assertSame(['b' => 22, 'c' => 33], $filtered->take(2)->toArray());
        $this->assertSame([], $filtered->take(0)->toArray());
    }

    public function test_invoke(){
        $map = new Map([
            'a' => new MapTestSampleValue(11),
            'b' => new MapTestSampleValue(22),
        ]);
        $iter = $map->invoke('getValue')->map(function($x){ return 2 * $x; });
        $this->assertSame(['a' => 22, 'b' => 44], $iter->toArray());
    }

}

class MapTestSampleValue {
    private $value;
    public function __construct($value){
        $this->value = $value;
    }
    public function getValue(){
        return $this->value;
    }
}

