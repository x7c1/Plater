<?
namespace x7c1\plater\collection\iterator;

trait Xc_IteratorBase {
    public function map($callback){
        return new Xc_MappedIterator($this, $callback);
    }
    public function filter($callback){
        return new Xc_FilteredIterator($this, $callback);
    }
}

class Xc_Iterator implements \Iterator{
    use Xc_IteratorBase;

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

trait Xc_IteratorDelegatee {
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

class Xc_MappedIterator implements \Iterator{
    use Xc_IteratorBase;
    use Xc_IteratorDelegatee;

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

class Xc_FilteredIterator implements \Iterator{
    use Xc_IteratorBase;
    use Xc_IteratorDelegatee;

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

