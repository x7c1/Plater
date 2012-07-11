<?
use x7c1\plater\collection\immutable\Map;

class MapTest extends \PHPUnit_Framework_TestCase{

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
        $iter = $map->filter(function($entry){ return $entry->getKey() === 'a' ; });
        $this->assertSame(['a' => 11], $iter->toArray());
        $this->assertTrue($iter->has('a'));
        $this->assertFalse($iter->has('b'));
    }

    public function test_filter_value(){
        $map = new Map([
            'a' => 11,
            'b' => 22,
        ]);
        $iter = $map->filter(function($entry){ return $entry->getValue() > 20; });
        $this->assertSame(['b' => 22], $iter->toArray());
        $this->assertTrue($iter->has('b'));
        $this->assertFalse($iter->has('a'));
    }

    public function test_map(){
        $map = new Map([
            'a' => 11,
            'b' => 22,
        ]);
        $iter = $map->map(function($entry){ return $entry->getValue() * 2; });
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

    public function test_invoke(){
        $map = new Map([
            'a' => 11,
            'b' => 22,
        ]);
        $iter = $map->invoke('getValue')->map(function($x){ return 2 * $x; });
        $this->assertSame(['a' => 22, 'b' => 44], $iter->toArray());

        $iter = $map->invoke('getKey');
        $this->assertSame(['a' => 'a', 'b' => 'b'], $iter->toArray());
    }

}

