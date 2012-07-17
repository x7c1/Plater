<?
namespace x7c1\plater\collection\iterator;

class RangeIterator implements CopyableIterator{

    private $key;
    private $current;
    private $start;
    private $end;

    public function __construct($start, $end){
        $this->key = 0;
        $this->current = $start;
        $this->start = $start;
        $this->end = $end;
    }

    public function current(){
        return $this->current;
    }
    public function key(){
        return $this->key;
    }
    public function next(){
        if ($this->valid()){
            $this->key++;
            $this->current++;
        }
        return $this->current;
    }
    public function rewind(){
        $this->key = 0;
        $this->current = $this->start;
    }
    public function valid(){
        return $this->current <= $this->end;
    }

    public function copyIterator(){
        return new RangeIterator($this->start, $this->end);
    }

}

