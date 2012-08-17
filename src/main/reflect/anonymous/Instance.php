<?
namespace x7c1\plater\reflect\anonymous;

class Instance {

    private $array;

    public static function create($array){
        return new self($array);
    }

    public function __construct($array){
        $this->array = $array;
    }

    public function __set($key, $value){
        throw new \BadMethodCallException;
    }

    public function __call($method, $args){
        $callee = $this->array[$method]->bindTo($this);
        return call_user_func_array($callee, $args);
    }
}

