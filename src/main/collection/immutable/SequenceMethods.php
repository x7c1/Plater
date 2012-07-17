<?
namespace x7c1\plater\collection\immutable;

trait SequenceMethods{

    public function toArray(){
        $array = [];
        foreach($this as $value){
            $array[] = $value;
        }
        return $array;
    }
}

