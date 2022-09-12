<?php

namespace dp\Iterator;

use app\dp\Iterator\Book;
use JetBrains\PhpStorm\ArrayShape;
use PHPUnit\Framework\TestCase;

/**
 * 本オブジェクトを期待通りに生成できるか検証
 */
class BookTest extends TestCase
{

    #[ArrayShape(['simple Book Name' => "string[]", 'include space' => "string[]", '日本語' => "string[]"])]
    public function bookProvider(): array
    {
        return [
            'simple Book Name' => ['Jaws', 'Jaws'],
            'include space' => ["Alice's Adventures in Wonderland", "Alice's Adventures in Wonderland"],
            '日本語' => ['吾輩は猫である', '吾輩は猫である'],
        ];
    }

    // つくられた本オブジェクトのname属性へタイトルが設定されるか
    /**
     * @dataProvider bookProvider
     *
     * @param string $title 本のタイトル
     * @param string $expected 期待値
     */
    public function testBookCreation(string $title, string $expected)
    {
        // WHEN
        $actual = new Book($title);
        // THEN
        $this->assertSame($actual->name, $expected);
    }
}
