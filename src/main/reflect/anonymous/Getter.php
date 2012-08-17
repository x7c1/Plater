<?
namespace x7c1\plater\reflect\anonymous;

class Getter {

    private $instance;

    public static function create($array){
        return new self($array);
    }

    public function __construct($array){
        $getters = [];
        foreach($array as $key => $value){
            $method = 'get' . ucfirst($key);
            $getters[$method] = function()use($value){ return $value; };
        }
        $this->instance = Instance::create($getters);
    }

    public function __set($key, $value){
        $this->instance->__set($key, $value);
    }

    public function __call($method, $args){
        return $this->instance->__call($method, $args);
    }
}

