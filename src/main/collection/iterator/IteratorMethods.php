<?
namespace x7c1\plater\collection\iterator;

trait IteratorMethods {

    /**
     * $this : IteratorAggregate
     * $this->underlying : CopyableIterator
     */

    public function map($callback){
        return $this->buildFrom(new MapIterator($this->getIterator(), $callback));
    }

    public function filter($callback){
        return $this->buildFrom(new FilterIterator($this->getIterator(), $callback));
    }

    public function take($count){
        return $this->buildFrom(new method\TakeIterator($this->getIterator(), $count));
    }

    public function invoke($method){
        return $this->buildFrom(new method\InvokeIterator($this->getIterator(), $method));
    }

    public function getIterator(){
        return $this->underlying->copyIterator();
    }

    private function buildFrom(CopyableIterator $underlying){
        $class = get_class($this);
        return new $class($underlying);
    }

}

/**
 * memo:
 *   case of infinite iterator
 *     -[rewind]
 *     -[valid current key next]+
 *   case of finite iterator
 *     -[rewind]
 *     -[valid current key next]*
 *     -[valid]
 */

class MapIterator implements CopyableIterator{

    use IteratorDelegator;

    private $underlying;
    private $callback;

    public function __construct(CopyableIterator $iterator, $callback){
        $this->underlying = $iterator;
        $this->callback = $callback;
    }

    public function current(){
        $key = $this->underlying->key();
        $current = $this->underlying->current();
        return call_user_func($this->callback, $current, $key);
    }

    public function copyIterator(){
        return new MapIterator($this->underlying->copyIterator(), $this->callback);
    }
}

class FilterIterator implements CopyableIterator{

    use IteratorDelegator;

    private $underlying;
    private $callback;

    public function __construct(CopyableIterator $iterator, $callback){
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

    public function copyIterator(){
        return new FilterIterator($this->underlying->copyIterator(), $this->callback);
    }

    private function inspect_next(){
        $is_valid = $this->underlying->valid();
        if ($is_valid){
            $key = $this->underlying->key();
            $current = $this->underlying->current();
            $is_target = call_user_func($this->callback, $current, $key);
        } else {
            $is_target = false;
        }
        return [$is_target, $is_valid];
    }
}

