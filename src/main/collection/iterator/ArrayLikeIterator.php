<?
namespace x7c1\plater\collection\iterator;

use x7c1\plater\collection\Arrayable;

class ArrayLikeIterator implements \IteratorAggregate, Arrayable{

    use IteratorMethods;

    private $underlying;

    public function __construct($underlying=[]){
        $this->assertIterableType($underlying);
        $this->underlying = $underlying;
    }

    public function getIterator(){
        return ($this->underlying instanceof CopyableIterator) ?
            $this->underlying->copyIterator():
            new ArrayLikeIterator_FromArray($this->underlying);
    }

    public function toArray(){
        $array = [];
        foreach($this as $value){
            $array[] = $value;
        }
        return $array;
    }
}

trait ArrayLikeDelegator{

    public function current(){
        return $this->underlying[$this->position];
    }
    public function key(){
        return $this->position;
    }
    public function next(){
        ++$this->position;
    }
    public function rewind(){
        $this->position = 0;
    }
    public function valid(){
        $count = count($this->underlying);
        return $this->position < $count;
    }
}

class ArrayLikeIterator_FromArray implements CopyableIterator{

    use ArrayLikeDelegator;

    private $position;
    private $underlying;

    public function __construct(array $array){
        $this->position = 0;
        $this->underlying = $array;
    }

    public function copyIterator(){
        return new ArrayLikeIterator_FromArray($this->underlying);
    }

}

