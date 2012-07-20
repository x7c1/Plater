<?
namespace x7c1\plater\collection\iterator\method;

use x7c1\plater\collection\iterator\CopyableIterator;
use x7c1\plater\collection\iterator\IteratorDelegator;

class DropIterator implements CopyableIterator{

    use IteratorDelegator;

    private $underlying;
    private $target_count;
    private $original;

    public function __construct(CopyableIterator $iterator, $count){
        $position = 0;
        $is_target = function($_) use($count, &$position){
            return ($count - 1) < $position++;
        };
        $this->underlying = new FilterIterator($iterator, $is_target);
        $this->target_count = $count;
        $this->original = $iterator;
    }

    public function copyIterator(){
        return new DropIterator($this->original->copyIterator(), $this->target_count);
    }

}

