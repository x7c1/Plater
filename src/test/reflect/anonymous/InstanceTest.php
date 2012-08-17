<?
use x7c1\plater\reflect\anonymous\Instance;

class InstanceTest extends \PHPUnit_Framework_TestCase{

    public function test_create(){
        $user = Instance::create([
            'getFirstName' => function(){ return 'Taro'; },
            'getLastName' => function(){ return 'Yamada'; },
        ]);
        $this->assertSame('Taro', $user->getFirstName());
        $this->assertSame('Yamada', $user->getLastName());
    }

    public function test_public_variable_is_not_allowed(){
        try{
            $user = Instance::create([]);
            $user->age = 40;
            $this->failed('BadMethodCallException not thrown');
        } catch(BadMethodCallException $e){
            $this->assertTrue(true);
        }
    }

}

