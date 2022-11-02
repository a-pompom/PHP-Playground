<?php

namespace tests\simpleForm;

use app\simpleForm\element\CheckBox;
use JetBrains\PhpStorm\ArrayShape;
use PHPUnit\Framework\TestCase;

class CheckBoxTest extends TestCase
{
    // チェックボックスでチェックが付与されたものを保持できているか
    #[ArrayShape(['some checked' => "array", 'nothing checked' => "array"])]
    public function valuesProvider(): array
    {
        $someChecked = function (): array {
            $choices = ['morning', 'afternoon', 'evening'];
            $values = ['morning', 'evening'];
            $expected = new CheckBox([], []);
            $expected->values = [
                'morning',
                'evening'
            ];

            return [$choices, $values, $expected];
        };

        $nothingChecked = function (): array {
            $choices = ['morning', 'afternoon', 'evening'];
            $values = [];
            $expected = new CheckBox([], []);
            $expected->values = [];

            return [$choices, $values, $expected];
        };

        return [
            'some checked' => $someChecked(),
            'nothing checked' => $nothingChecked(),
        ];
    }

    /**
     * @dataProvider valuesProvider
     *
     * @param array $choices 選択肢
     * @param array $values チェックが付与されたvalue属性値
     * @param CheckBox $expected 期待値
     */
    public function testValues(array $choices, array $values, CheckBox $expected)
    {
        // WHEN
        $actual = new CheckBox($choices, $values);
        // THEN
        $this->assertTrue($actual->values === $expected->values);
    }

    // 選択肢のチェック状態を表現できるか
    #[ArrayShape(['some checked' => "array", 'nothing checked' => "array"])]
    public function checkStateProvider(): array
    {
        $someChecked = function (): array {
            $choices = ['犬', '猫', '虎'];
            $values = ['犬'];
            $expected = new CheckBox([], []);
            $expected->checkState = [
                '犬' => true,
                '猫' => false,
                '虎' => false,
            ];
            $expected->values = [
                '犬',
            ];

            return [$choices, $values, $expected];
        };

        $nothingChecked = function (): array {
            $choices = ['犬', '猫', '虎'];
            $values = [];
            $expected = new CheckBox([], []);
            $expected->checkState = [
                '犬' => false,
                '猫' => false,
                '虎' => false,
            ];
            $expected->values = [
            ];

            return [$choices, $values, $expected];
        };

        return [
            'some checked' => $someChecked(),
            'nothing checked' => $nothingChecked(),
        ];

    }

    /**
     * @dataProvider checkStateProvider
     *
     * @param array $choices 選択肢
     * @param array $values チェックが付与されたvalue属性値
     * @param CheckBox $expected 期待値
     */
    public function testCheckState(array $choices, array $values, CheckBox $expected)
    {
        // WHEN
        $actual = new CheckBox($choices, $values);
        // THEN
        $this->assertTrue($actual->equals($expected));
    }
}
