<?php
namespace x7c1\plater\collection\iterator;

trait IteratorDelegator {

    public function current(){
        return $this->underlying->current();
    }
    public function key(){
        return $this->underlying->key();
    }
    public function next(){
        $this->underlying->next();
    }
    public function rewind(){
        $this->underlying->rewind();
    }
    public function valid(){
        return $this->underlying->valid();
    }
}

