<?
namespace x7c1\plater\collection\immutable;

use x7c1\plater\collection\SequenceLike;
use x7c1\plater\collection\iterator\RawArrayIterator;

class Sequence implements SequenceLike, \IteratorAggregate{

    use SequenceMethods;

    private function createIterator($underlying=[]){
        return new RawArrayIterator($underlying);
    }
}

