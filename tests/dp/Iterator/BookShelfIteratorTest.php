<?php

namespace dp\Iterator;

use app\dp\Iterator\Book;
use app\dp\Iterator\BookShelf;
use JetBrains\PhpStorm\Pure;
use PHPUnit\Framework\TestCase;

class BookShelfIteratorTest extends TestCase
{
    // 本を追加した本棚を生成
    public function bookShelfProvider(): array
    {
        $books = [
            new Book('よくわかるPHP'),
            new Book('PHP for beginners'),
            new Book('たのしいPHP'),
        ];
        // WHEN
        $bookShelf = new BookShelf();
        foreach ($books as $book) {
            $bookShelf->append($book);
        }

        return [
            '' => [$bookShelf]
        ];
    }


    // 本棚から1つずつ要素を取り出せるか

    /**
     * @dataProvider bookShelfProvider
     *
     * @param BookShelf $bookShelf 本棚
     */
    public function testNext(BookShelf $bookShelf): void
    {
        // GIVEN
        $expectedList = [
            'よくわかるPHP',
            'PHP for beginners',
            'たのしいPHP'
        ];
        // WHEN
        $iterator = $bookShelf->iterator();
        $actualList = [
            $iterator->next()->name,
            $iterator->next()->name,
            $iterator->next()->name,
        ];
        // THEN
        $this->assertSame($actualList, $expectedList);
    }

    // 本棚から本を取り出せるときはtrue, 取り出せないときはfalseが得られるか

    /**
     * @dataProvider bookShelfProvider
     *
     * @param BookShelf $bookShelf 本棚
     */
    public function testHasNext(BookShelf $bookShelf): void
    {
        // GIVEN
        $expectedList = [
            true,
            true,
            true,
            false
        ];

        // WHEN
        $iterator = $bookShelf->iterator();
        $actualList = [];
        while ($actual = $iterator->hasNext()) {
            $actualList[] = $actual;
            $iterator->next();
        }
        $actualList[] = $actual;

        // THEN
        $this->assertSame($actualList, $expectedList);
    }
}
