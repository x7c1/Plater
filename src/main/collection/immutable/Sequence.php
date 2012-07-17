<?
namespace x7c1\plater\collection\immutable;

use x7c1\plater\collection\SequenceLike;
use x7c1\plater\collection\iterator;

class Sequence implements SequenceLike, \IteratorAggregate{

    use iterator\IteratorMethods;

    private $underlying;

    public function __construct($underlying=[]){
        $this->underlying = iterator\CopyableBuilder::build($underlying);
    }

    public function toArray(){
        $array = [];
        foreach($this as $value){
            $array[] = $value;
        }
        return $array;
    }
}

