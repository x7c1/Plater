<?
namespace x7c1\plater\collection\iterator;

trait IteratorMethods {

    /**
     * $this : IteratorAggregate
     * $this->underlying : CopyableIterator
     */

    public function map($callback){
        return $this->buildFrom(new method\MapIterator($this->getIterator(), $callback));
    }

    public function filter($callback){
        return $this->buildFrom(new method\FilterIterator($this->getIterator(), $callback));
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

