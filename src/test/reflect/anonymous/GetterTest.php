<?
use x7c1\plater\reflect\anonymous\Getter;

class GetterTest extends \PHPUnit_Framework_TestCase{

    public function test_create(){
        $user = Getter::create([
            'firstName' => 'Taro',
            'lastName' => 'Yamada',
        ]);
        $this->assertSame('Taro', $user->getFirstName());
        $this->assertSame('Yamada', $user->getLastName());
    }

}

