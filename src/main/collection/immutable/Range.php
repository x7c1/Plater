<?
namespace x7c1\plater\collection\immutable;

use x7c1\plater\collection\SequenceLike;
use x7c1\plater\collection\iterator\RangeIterator;

class Range implements SequenceLike, \IteratorAggregate{

    use SequenceMethods;

    private function createIterator($start, $end){
        if(!is_int($start) || !is_int($end)){
            throw new \InvalidArgumentException('arguments unknown type');
        }
        return new RangeIterator($start, $end);
    }

}

