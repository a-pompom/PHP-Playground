<?php

namespace dp\Iterator;

use app\dp\Iterator\Book;
use app\dp\Iterator\BookShelf;
use app\dp\Iterator\BookShelfIterator;
use JetBrains\PhpStorm\Pure;
use PHPUnit\Framework\TestCase;

/**
 * 本棚に本を追加し、本棚から参照できるか検証
 */
class BookShelfTest extends TestCase
{

    // 本棚へ追加する本
    #[Pure] public function booksProvider(): array
    {
        $books = [
            new Book('よくわかるPHP'),
            new Book('PHP for beginners'),
            new Book('たのしいPHP'),
        ];

        return [
            '' => [$books]
        ];
    }

    // 本棚に本を追加し、追加したものを取り出せるか
    /**
     * @dataProvider booksProvider
     *
     * @param array $books 本棚へ追加する本
     */
    public function testGetBook(array $books): void
    {
        // GIVEN
        $expectedList = [
            'よくわかるPHP',
            'PHP for beginners',
            'たのしいPHP'
        ];
        // WHEN
        $bookShelf = new BookShelf();
        foreach ($books as $book) {
            $bookShelf->append($book);
        }
        // THEN
        for ($i = 0; $i < count($expectedList); $i++) {
            $this->assertSame($bookShelf->take($i)->name, $expectedList[$i]);
        }
    }

    // 本棚の要素数は追加した冊数と一致するか
    /**
     * @dataProvider booksProvider
     *
     * @param array $books 本棚へ追加する本
     */
    public function testSize(array $books): void
    {
        // GIVEN
        $expected = 3;
        // WHEN
        $bookShelf = new BookShelf();
        foreach ($books as $book) {
            $bookShelf->append($book);
        }
        $this->assertSame($bookShelf->size(), $expected);
    }

    // 本棚から得られるIteratorはBookShelfIteratorのインスタンスか
    public function testGetIterator()
    {
        // WHEN
        $bookShelf = new BookShelf();
        // THEN
        $this->assertInstanceOf(BookShelfIterator::class, $bookShelf->iterator());
    }
}
