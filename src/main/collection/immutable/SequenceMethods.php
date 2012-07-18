<?
namespace x7c1\plater\collection\immutable;

use x7c1\plater\collection\iterator\IteratorMethods;

trait SequenceMethods{

    use IteratorMethods;

    public function toArray(){
        $array = [];
        foreach($this as $value){
            $array[] = $value;
        }
        return $array;
    }
}

