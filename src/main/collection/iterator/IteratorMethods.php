<?
namespace x7c1\plater\collection\iterator;

trait IteratorMethods {

    public function map($callback){
        return $this->buildFrom(new MapIterator($this->getIterator(), $callback));
    }
    public function filter($callback){
        return $this->buildFrom(new FilterIterator($this->getIterator(), $callback));
    }
    public function invoke($method){
        return $this->buildFrom(new InvokeIterator($this->getIterator(), $method));
    }
    private function buildFrom($underlying){
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

class MapIterator implements \Iterator{

    use IteratorMethods;
    use IteratorDelegator;

    private $underlying;
    private $callback;

    public function __construct(\Iterator $iterator, $callback){
        $this->underlying = $iterator;
        $this->callback = $callback;
    }

    public function current(){
        $key = $this->underlying->key();
        $current = $this->underlying->current();
        return call_user_func($this->callback, $current, $key);
    }
}

class FilterIterator implements \Iterator{

    use IteratorMethods;
    use IteratorDelegator;

    private $underlying;
    private $callback;

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

class InvokeIterator implements \Iterator{

    use IteratorMethods;
    use IteratorDelegator;

    private $underlying;
    private $method;

    public function __construct(\Iterator $iterator, $method){
        $this->underlying = $iterator;
        $this->method = $method;
    }

    public function current(){
        $current = $this->underlying->current();
        return $current->{$this->method}();
    }

}

