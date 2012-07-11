<?
namespace x7c1\plater\collection\iterator;

class ArrayLikeIterator implements \Iterator{

    use IteratorMethods;
    use ArrayLikeMethods;
    use IteratorDelegator;

    private $underlying;

    public function __construct($underlying=[]){
        $this->underlying = ($underlying instanceof \Iterator) ?
            $underlying:
            new ArrayLikeIterator_FromArray($underlying);
    }
}

trait ArrayLikeMethods {

    public function toArray(){
        $array = [];
        foreach($this as $x){
            $array[] = $x;
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

class ArrayLikeIterator_FromArray implements \Iterator{

    use ArrayLikeDelegator;

    private $position;
    private $underlying;

    /**
     * @param   mixin   @array  array | ArrayAccess, Countable
     */
    public function __construct($array){
        $this->position = 0;
        $this->underlying = $array;
    }
}

