<?
namespace x7c1\plater\collection\iterator;

interface CopyableIterator extends \Iterator{

    /**
     * @return CopyableIterator
     */
    public function copyIterator();
}

