<?
namespace x7c1\plater\collection\iterator\method;

use x7c1\plater\collection\iterator\CopyableIterator;
use x7c1\plater\collection\iterator\IteratorDelegator;

class TakeIterator implements CopyableIterator{

    use IteratorDelegator;

    private $underlying;
    private $target_count;
    private $is_target;

    public function __construct(CopyableIterator $iterator, $count){
        $position = 0;
        $this->is_target = function() use($count, &$position){
            return ++$position <= $count;
        };
        $this->underlying = $iterator;
        $this->target_count = $count;
    }

    public function valid(){
        return call_user_func($this->is_target) && $this->underlying->valid();
    }

    public function copyIterator(){
        return new TakeIterator($this->underlying->copyIterator(), $this->target_count);
    }
}

