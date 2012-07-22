<?
namespace x7c1\plater\collection\immutable;

use x7c1\plater\collection\SequenceLike;
use x7c1\plater\collection\iterator;

class Range implements SequenceLike, \IteratorAggregate{

    use SequenceMethods;

    private $underlying;

    public static function create($start, $end){
        return new self($start, $end);
    }

    public function __construct($start, $end=null){
        $this->underlying = $this->build_copyable($start, $end);
    }
    private function build_copyable($start, $end){
        if ($start instanceof iterator\CopyableIterator)
            $iter = $start;
        elseif(is_int($start) && is_int($end))
            $iter = new iterator\RangeIterator($start, $end);
        else
            throw new \InvalidArgumentException('arguments unknown type');
        return $iter;
    }
}

