<?
namespace x7c1\plater\collection\iterator\method;

use x7c1\plater\collection\iterator\CopyableIterator;
use x7c1\plater\collection\iterator\IteratorDelegator;

class TakeIterator implements CopyableIterator{

    use IteratorDelegator
    {
        IteratorDelegator::valid as baseValid;
    }

    private $underlying;
    private $target_count;
    private $position;

    public function __construct(CopyableIterator $iterator, $count){
        $this->underlying = $iterator;
        $this->target_count = $count;
        $this->position = 0;
    }

    public function valid(){
        $this->position++;
        $in_range = $this->position <= $this->target_count;
        return $in_range && $this->baseValid();
    }

    public function copyIterator(){
        return new TakeIterator($this->underlying->copyIterator(), $this->target_count);
    }
}

