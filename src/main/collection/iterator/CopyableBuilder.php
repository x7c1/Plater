<?
namespace x7c1\plater\collection\iterator;

class CopyableBuilder {

    /**
     * @return   CopyableIterator
     */
    public static function build($underlying){
        if (is_array($underlying))
            $iterator = new RawArrayIterator($underlying);
        elseif($underlying instanceof CopyableIterator)
            $iterator = $underlying;
        else
            throw new \InvalidArgumentException('unknown $underlying type');
        return $iterator;
    }
}

