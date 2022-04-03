<?php

namespace hello;

use app\hello\Hello;
use PHPUnit\Framework\TestCase;

class HelloTest extends TestCase
{

    // assertSame: https://phpunit.readthedocs.io/en/latest/assertions.html#assertsame
    // 文字列Helloが返却されるか
    public function testHello()
    {
        // GIVEN
        $expected = 'Hello';
        $sut = new Hello();
        // WHEN
        $actual = $sut->sayHello();

        // THEN
        $this->assertSame($expected, $actual);
    }
}