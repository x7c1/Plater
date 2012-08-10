Feature
--------
#### Higher-order functions ####

* Plater's iterator supports some common but useful methods.

        $seq = Sequence::create([2, 3, 4, 5, 6])
            ->take(4)
            ->filter(function($x){return $x > 2;})
            ->map(function($x){return $x * 2;})
            ->drop(2); 
        foreach($seq as $x) echo $x;// 10

#### Lazy iterator ####

* Evaluated when needed.

        foreach(range(1, 700000) as $i){
            // Memory: 101.50Mb
        }
        use x7c1\plater\collection\immutable\Range;
        foreach(new range(1, 700000) as $i){
            // Memory: 2.50Mb
        }

#### Same-result-type principle ####

* Type of the returned value is same as its invocant.

        $sequence = Sequence::create([1, 3])->take(1);
        $this->assertTrue($sequence instanceof Sequence);
        
        $range = Range::create(1, 3)->take(1);
        $this->assertTrue($range instanceof Range);

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
