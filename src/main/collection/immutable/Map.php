<?
namespace x7c1\plater\collection\immutable;

use x7c1\plater\collection\iterator\IteratorMethods;
use x7c1\plater\collection\iterator\IteratorDelegator;

class Map implements \Iterator{

    use IteratorMethods;
    use IteratorDelegator;

    private $underlying;

    private $evaluated;

    public function __construct($underlying){
        $this->underlying = ($underlying instanceof \Iterator) ?
            $underlying:
            new MapIterator_FromArray($underlying);
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
            $array = [];
            foreach($this as $key => $entry){
                $array[$key] = ($entry instanceof MapEntry) ?
                    $entry->getValue(): $entry;
            }
            $this->evaluated = $array;
        }
        return $this->evaluated;
    }

}

class MapIterator_FromArray implements \Iterator{

    private $has_next_entry;
    private $underlying;

    public function __construct($array){
        $this->underlying = $array;
        $this->has_next_entry = count($array) > 0;
    }

    public function current(){
        return current($this->underlying);
    }
    public function key(){
        return key($this->underlying);
    }
    public function next(){
        $this->has_next_entry = each($this->underlying) && $this->key();
    }
    public function rewind(){
        reset($this->underlying);
        $this->has_next_entry = count($this) > 0;
    }
    public function valid(){
        return $this->has_next_entry;
    }

}

