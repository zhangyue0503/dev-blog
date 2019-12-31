<?php

class A {
    final function testA(){
        echo 'This is class A!', PHP_EOL;
    }
}

class childA extends A {
    //  Fatal error: Cannot override final method A::testA()
    function testA(){
        echo 'This is class childA', PHP_EOL;
    }
}

final class B {
    function testB(){
        echo 'This is class B!', PHP_EOL;
    }
}

// Fatal error: Class childB may not inherit from final class (B)
class childB extends B{

}

interface C {
    // Fatal error: Access type for interface method C::testC() must be omitted 
    final function testC();
}




