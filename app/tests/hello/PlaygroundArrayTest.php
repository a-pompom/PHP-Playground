<?php

namespace hello;

use app\hello\ArrayPlayground;
use PHPUnit\Framework\TestCase;

class PlaygroundArrayTest extends TestCase
{
    // インデックス形式の配列で等価比較できるか
    public function testIndexed()
    {
        // GIVEN
        $expected = [1, 2, 3, 4, 5];
        $sut = new ArrayPlayground();
        // WHEN
        $actual = $sut->getIndexedArray();
        // THEN
        $this->assertSame($expected, $actual);
    }

    // 連想配列で等価比較できるか
    public function testAssociative()
    {
        // GIVEN
        $expected = [
            'pom' => 'pom',
            'pudding' => 'pudding',
        ];
        $sut = new ArrayPlayground();
        // WHEN
        $actual = $sut->getAssociativeArray();

        // THEN
        $this->assertSame($expected, $actual);
    }
}