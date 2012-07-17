<?
namespace x7c1\plater\collection\immutable;

use x7c1\plater\collection\Arrayable;
use x7c1\plater\collection\iterator\CopyableBuilder;
use x7c1\plater\collection\iterator\IteratorMethods;

class Sequence implements \IteratorAggregate, Arrayable{

    use IteratorMethods;

    private $underlying;

    public function __construct($underlying=[]){
        $this->underlying = CopyableBuilder::build($underlying);
    }

    public function toArray(){
        $array = [];
        foreach($this as $value){
            $array[] = $value;
        }
        return $array;
    }
}

