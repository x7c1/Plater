<?
namespace x7c1\plater\collection;

interface Iterable{

    public function map($callback);

    public function filter($callback);

    public function take($count);

    public function invoke($method);
}

