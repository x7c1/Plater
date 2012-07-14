<?
namespace x7c1\plater\collection\immutable;

use x7c1\plater\collection\Arrayable;
use x7c1\plater\collection\MapLike;
use x7c1\plater\collection\iterator\IteratorMethods;

class Map implements \IteratorAggregate, Arrayable, MapLike{

    use IteratorMethods;
    use MapLikeDelegator;

    private $underlying;
    private $accessor;

    public function __construct($underlying=[]){
        $this->underlying = $this->createUnderlying($underlying);
        $this->accessor = MapAccessorFactory::create($underlying);
    }

    public function toArray(){
        return $this->accessor->toArray();
    }
}

trait MapLikeDelegator{
    // $this : MapLike

    public function has($key){
        return array_key_exists($key, $this->toArray());
    }

    public function getOr($key, $default){
        return $this->has($key)?
            $this->toArray()[$key]:
            $default;
    }

    public function keys(){
        return array_keys($this->toArray());
    }

    public function values(){
        return array_values($this->toArray());
    }
}

use x7c1\plater\collection\iterator\CopyableIterator;

class MapAccessorFactory{

    /**
     * @return  MapLike
     */
    public static function create($underlying){
        if (is_array($underlying))
            $accessor = new MapAccessor_FromArray($underlying);
        elseif($underlying instanceof CopyableIterator)
            $accessor = new MapAccessor_FromIterator($underlying);
        else
            throw new \InvalidArgumentException('$underlying not map');
        return $accessor;
    }
}

class MapAccessor_FromArray implements MapLike {

    use MapLikeDelegator;

    private $underlying;

    public function __construct(array $underlying){
        $this->underlying = $underlying;
    }

    public function toArray(){
        return $this->underlying;
    }
}

class MapAccessor_FromIterator implements MapLike {

    use MapLikeDelegator;

    private $evaluated;
    private $underlying;

    public function __construct(CopyableIterator $underlying){
        $this->underlying = $underlying;
        $this->evaluated = null;
    }

    public function toArray(){
        if (!is_array($this->evaluated)){
            $this->evaluated = [];
            foreach($this->underlying as $key => $entry)
                $this->evaluated[$key] = $entry;
        }
        return $this->evaluated;
    }
}

