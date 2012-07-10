<?
namespace x7c1\plater\collection\iterator;

class ArrayLikeIterator implements \Iterator{

    use IteratorMethods;
    use ArrayLikeMethods;
    use IteratorDelegator;

    private $underlying;

    public function __construct($underlying=[]){
        $this->underlying = ($underlying instanceof \Iterator) ?
            new ArrayLikeIterator_FromIterator($underlying):
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

    use IteratorMethods;
    use ArrayLikeMethods;
    use ArrayLikeDelegator;

    private $position;
    private $underlying;

    public function __construct(array $array){
        $this->position = 0;
        $this->underlying = $array;
    }
}

class ArrayLikeIterator_FromIterator implements \Iterator{

    use IteratorMethods;
    use ArrayLikeMethods;
    use IteratorDelegator;

    private $underlying;

    public function __construct(\Iterator $iterator){
        $this->underlying = $iterator;
    }
}


