<?
namespace x7c1\plater\collection\immutable;

use x7c1\plater\collection\iterator\IteratorMethods;
use x7c1\plater\collection\iterator\CopyableIterator;

trait SequenceMethods{

    use IteratorMethods;

    private $underlying;

    public function __construct($x=null){
        if ($x instanceof CopyableIterator)
            $this->underlying = $x;
        else
            $this->underlying = $this->createSequenceUnderlying(func_get_args());
    }

    public function toArray(){
        $array = [];
        foreach($this as $value){
            $array[] = $value;
        }
        return $array;
    }

    private function createSequenceUnderlying($args){
        $method = new \ReflectionMethod(get_class($this), 'createIterator');
        $arity = $method->getNumberOfRequiredParameters();
        $missing = $arity - count($args);
        if ($missing > 0){
            $message = "Missing argument $missing";
            throw new \InvalidArgumentException($message);
        }
        return call_user_func_array([$this, 'createIterator'], $args);
    }
}

