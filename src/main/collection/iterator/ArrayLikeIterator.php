<?
namespace x7c1\plater\collection\iterator;

trait IteratorMethods {
    public function map($callback){
        return new MappedIterator($this, $callback);
    }
    public function filter($callback){
        return new FilteredIterator($this, $callback);
    }
}

class ArrayLikeIterator implements \Iterator{
    use IteratorMethods;

    protected $position;
    protected $underlying;

    public function __construct($array){
        $this->position = 0;
        $this->underlying = $array;
    }

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

trait IteratorDelegator {
    public function current(){
        return $this->underlying->current();
    }
    public function key(){
        return $this->underlying->key();
    }
    public function next(){
        $this->underlying->next();
    }
    public function rewind(){
        $this->underlying->rewind();
    }
    public function valid(){
        return $this->underlying->valid();
    }
}

class MappedIterator implements \Iterator{
    use IteratorMethods;
    use IteratorDelegator;

    protected $underlying;
    protected $callback;

    public function __construct(\Iterator $iterator, $callback){
        $this->underlying = $iterator;
        $this->callback = $callback;
    }

    public function current(){
        $current = $this->underlying->current();
        return call_user_func($this->callback, $current);
    }
}

class FilteredIterator implements \Iterator{
    use IteratorMethods;
    use IteratorDelegator;

    protected $underlying;
    protected $callback;

    public function __construct(\Iterator $iterator, $callback){
        $this->underlying = $iterator;
        $this->callback = $callback;
    }

    public function valid(){
        list($is_target, $is_valid) = $this->inspect_next();
        while(!$is_target && $is_valid){
            $this->underlying->next();
            list($is_target, $is_valid) = $this->inspect_next();
        }
        return $is_valid;
    }

    protected function inspect_next(){
        $is_valid = $this->underlying->valid();
        if ($is_valid){
            $is_target = call_user_func($this->callback, $this->underlying->current());
        } else {
            $is_target = false;
        }
        return [$is_target, $is_valid];
    }

}

