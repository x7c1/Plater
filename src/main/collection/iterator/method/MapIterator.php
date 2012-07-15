<?
namespace x7c1\plater\collection\iterator\method;

use x7c1\plater\collection\iterator\CopyableIterator;
use x7c1\plater\collection\iterator\IteratorDelegator;

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

