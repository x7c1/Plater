<?
namespace x7c1\plater\collection\iterator\method;

use x7c1\plater\collection\iterator\CopyableIterator;
use x7c1\plater\collection\iterator\IteratorDelegator;

class InvokeIterator implements CopyableIterator{

    use IteratorDelegator;

    private $underlying;
    private $method;

    public function __construct(CopyableIterator $iterator, $method){
        $this->underlying = $iterator;
        $this->method = $method;
    }

    public function current(){
        $current = $this->underlying->current();
        return $current->{$this->method}();
    }

    public function copyIterator(){
        return new InvokeIterator($this->underlying->copyIterator(), $this->method);
    }
}

