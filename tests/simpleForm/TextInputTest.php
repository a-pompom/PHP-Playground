<?php

namespace tests\simpleForm;

use app\simpleForm\element\TextInput;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use PHPUnit\Framework\TestCase;

class TextInputTest extends TestCase
{
    // 入力値のテキストを保持するオブジェクトがつくれるか
    #[Pure] #[ArrayShape(['empty' => "array", 'someValue' => "array", 'dangerous text' => "array"])]
    public function textValueProvider(): array
    {
        return [
            'empty' => ['', new TextInput('')],
            'someValue' => ['hello', new TextInput('hello')],
            'dangerous text' => ['<script>', new TextInput('<script>')]
        ];
    }

    /**
     * @dataProvider textValueProvider
     *
     * @param string $value 入力値
     * @param TextInput $expected 期待値
     */
    public function testValue(string $value, TextInput $expected)
    {
        // WHEN
        $actual = new TextInput($value);
        // THEN
        $this->assertTrue($actual->equals($expected));
    }
}
