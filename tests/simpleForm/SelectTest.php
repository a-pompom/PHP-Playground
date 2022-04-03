<?php

namespace tests\simpleForm;

use app\simpleForm\element\Select;
use JetBrains\PhpStorm\ArrayShape;
use PHPUnit\Framework\TestCase;

class SelectTest extends TestCase
{
    // 選択値を保持できるか
    #[ArrayShape(['some value selected' => "array"])]
    public function valueProvider(): array
    {
        return [
            'some value selected' => [['みかん', 'りんご', 'ばなな'], 'りんご', 'りんご']
        ];
    }

    /**
     * @dataProvider valueProvider
     *
     * @param array $choices 選択肢
     * @param string $selected 選択値
     * @param string $expected 期待値
     */
    public function testValue(array $choices, string $selected, string $expected)
    {
        // WHEN
        $select = new Select($choices, $selected);
        $actual = $select->selected;
        // THEN
        $this->assertSame($expected, $actual);
    }

    // 選択肢に無いものが選択されたとき、空値とみなせるか
    #[ArrayShape(['empty' => "array", 'invalid' => "array"])]
    public function invalidSelectValueProvider(): array
    {
        return [
            'empty' => [['春', '夏', '秋', '冬'], '', Select::NOTHING_SELECTED],
            'invalid' => [['春', '夏', '秋', '冬'], '新年', Select::NOTHING_SELECTED],
        ];
    }

    /**
     * @dataProvider invalidSelectValueProvider
     *
     * @param array $choices 選択肢
     * @param string $selected 選択値
     * @param string $expected 期待値
     */
    public function testInvalidSelectValue(array $choices, string $selected, string $expected)
    {
        // WHEN
        $select = new Select($choices, $selected);
        $actual = $select->selected;
        // THEN
        $this->assertSame($expected, $actual);
    }
}
