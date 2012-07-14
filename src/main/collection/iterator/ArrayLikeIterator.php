<?
namespace x7c1\plater\collection\iterator;

use x7c1\plater\collection\Arrayable;

class ArrayLikeIterator implements \IteratorAggregate, Arrayable{

    use IteratorMethods;

    private $underlying;

    public function __construct($underlying=[]){
        $this->assertIterableType($underlying);
        $this->underlying = $underlying;
    }

    public function toArray(){
        $array = [];
        foreach($this as $value){
            $array[] = $value;
        }
        return $array;
    }
}

