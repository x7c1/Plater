<?
namespace x7c1\plater\collection\iterator;

trait IteratorMethods {

    public function map($callback){
        return $this->buildFrom(new MapIterator($this, $callback));
    }
    public function filter($callback){
        return $this->buildFrom(new FilterIterator($this, $callback));
    }
    public function invoke($method){
        return $this->buildFrom(new InvokeIterator($this, $method));
    }
    public function getUnderlying(){
        return $this->underlying;
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

class MapIterator implements IteratorBase{

    use IteratorMethods;
    use IteratorDelegator;

    private $underlying;
    private $callback;

    public function __construct(IteratorBase $iterator, $callback){
        $this->underlying = $iterator;
        $this->callback = $callback;
    }

    public function current(){
        $current = $this->underlying->current();
        return call_user_func($this->callback, $current);
    }
}

class FilterIterator implements IteratorBase{

    use IteratorMethods;
    use IteratorDelegator;

    private $underlying;
    private $callback;

    public function __construct(IteratorBase $iterator, $callback){
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
            $is_target = call_user_func($this->callback, $this->underlying->current());
        } else {
            $is_target = false;
        }
        return [$is_target, $is_valid];
    }
}

class InvokeIterator implements IteratorBase{

    use IteratorMethods;
    use IteratorDelegator;

    private $underlying;
    private $method;

    public function __construct(IteratorBase $iterator, $method){
        $this->underlying = $iterator;
        $this->method = $method;
    }

    public function current(){
        $current = $this->underlying->current();
        return $current->{$this->method}();
    }

}

