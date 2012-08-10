Feature
--------
#### Higher-order functions ####

* Plater's iterator supports some common but useful methods.

        $array = Sequence::create([2, 3, 4, 5, 6])
            ->take(4)
            ->filter(function($x){return $x > 2;})
            ->map(function($x){return $x * 2;})
            ->drop(2)
            ->toArray();
        $this->assertSame([10], $array);

#### Lazy iterator ####

* Evaluated when needed.

        foreach(range(1, 700000) as $i){
            // Memory: 101.50Mb
        }
        use x7c1\plater\collection\immutable\Range;
        foreach(new range(1, 700000) as $i){
            // Memory: 2.50Mb
        }

Goal
--------
#### Unlike PHP ####

Plater is a library that aims to ease the burden of writing PHP.
It plans to provide some basic data-structures and framework, 
for instance, to make a functional implementation more easily.

Test
--------

1. Install PHPUnit

2. run the tests with an option --bootstrap

        phpunit --bootstrap=./src/main/autoload.php --include-path=./ src/test
        
License
--------

Plater is released under the MIT license

* http://www.opensource.org/licenses/MIT
