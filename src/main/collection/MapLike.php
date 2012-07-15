<?
namespace x7c1\plater\collection;

interface MapLike extends Arrayable{

    /**
     * @param   string  $key
     * @return  bool
     */
    public function has($key);

    /**
     * @param   string  $key
     * @param   mixed   $default
     * @return  mixed
     */
    public function getOr($key, $default);

    /**
     * @return  array
     */
    public function keys();

    /**
     * @return  array
     */
    public function values();

    /**
     * @return  array
     */
    public function toArray();
}

