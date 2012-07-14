<?
namespace x7c1\plater\collection\iterator;

class RawArrayIterator implements CopyableIterator{

    private $has_next_entry;
    private $underlying;

    public function __construct(array $array){
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
        $this->has_next_entry = count($this->underlying) > 0;
    }
    public function valid(){
        return $this->has_next_entry;
    }

    public function copyIterator(){
        return new RawArrayIterator($this->underlying);
    }

}

