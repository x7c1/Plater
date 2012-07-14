<?
namespace x7c1\plater\collection\immutable;

use x7c1\plater\collection\Arrayable;
use x7c1\plater\collection\iterator\IteratorMethods;

class Map implements \IteratorAggregate, Arrayable{

    use IteratorMethods;

    private $underlying;
    private $evaluated = null;

    public function __construct($underlying=[]){
        $this->assertIterableType($underlying);
        $this->underlying = $underlying;
    }

    public function has($key){
        $array = $this->toArray();
        return array_key_exists($key, $array);
    }

    public function getOr($key, $default){
        if ($this->has($key)){
            $value = $this->toArray()[$key];
        } else {
            $value = $default;
        }
        return $value;
    }

    public function keys(){
        return array_keys($this->toArray());
    }

    public function values(){
        return array_values($this->toArray());
    }

    public function toArray(){
        if (!is_array($this->evaluated)){
            $this->evaluated = [];
            foreach($this as $key => $entry)
                $this->evaluated[$key] = $entry;
        }
        return $this->evaluated;
    }
}

