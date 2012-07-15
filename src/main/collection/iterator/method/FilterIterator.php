<?
namespace x7c1\plater\collection\iterator\method;

use x7c1\plater\collection\iterator\CopyableIterator;
use x7c1\plater\collection\iterator\IteratorDelegator;

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

