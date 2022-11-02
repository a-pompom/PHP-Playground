<?php

namespace tests\simpleForm;

use app\simpleForm\element\RadioButton;
use JetBrains\PhpStorm\ArrayShape;
use PHPUnit\Framework\TestCase;

/**
 * ラジオボタンを表現できるか検証
 */
class RadioButtonTest extends TestCase
{
    // 選択値を保持できるか
    #[ArrayShape(['value selected' => "array"])]
    public function valueProvider(): array
    {
        return [
            'value selected' => [['犬', '猫'], '犬', '犬']
        ];
    }

    /**
     * @dataProvider valueProvider
     *
     * @param array $choices 選択肢
     * @param string $value 選択値
     * @param string $expected 期待値
     */
    public function testValue(array $choices, string $value, string $expected)
    {
        // WHEN
        $radioButton = new RadioButton($choices, $value);
        $actual = $radioButton->selected;
        // THEN
        $this->assertSame($expected, $actual);
    }

    // 選択肢外のものが選択されたとき、選択値は空値となるか
    #[ArrayShape(['empty' => "array", 'not in choices' => "array"])]
    public function invalidSelectValueProvider(): array
    {
        return [
            'empty' => [['肉', '魚', '野菜'], '', RadioButton::NOTHING_SELECTED],
            'not in choices' => [['鯵', '鰤', '鮃'], '鰹', RadioButton::NOTHING_SELECTED]
        ];
    }

    /**
     * @dataProvider invalidSelectValueProvider
     *
     * @param array $choices 選択肢
     * @param string $value 選択値
     * @param string $expected 期待値
     */
    public function testInvalidSelectValue(array $choices, string $value, string $expected)
    {
        // WHEN
        $radioButton = new RadioButton($choices, $value);
        $actual = $radioButton->selected;
        // THEN
        $this->assertSame($expected, $actual);
    }
}
