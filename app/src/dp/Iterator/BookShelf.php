<?php

namespace app\dp\Iterator;

use JetBrains\PhpStorm\Pure;

/**
 * 本棚を表現することを責務に持つ
 */
class BookShelf implements Aggregate
{
    // 本棚の本
    private array $books;

    /**
     * 本棚から本を1冊取り出す
     *
     * @param int $index 対象の位置
     * @return Book 取り出された本要素
     */
    public function take(int $index): Book
    {
        return $this->books[$index];
    }

    /**
     * 本の要素数を返却
     *
     * @return int 本棚が持つ本の冊数
     */
    public function size(): int
    {
        return count($this->books);
    }

    /**
     * 本棚へ本を追加
     * @param Book $book 追加したい本
     */
    public function append(Book $book): void
    {
        $this->books[] = $book;
    }

    /**
     * 本棚を反復するためのインタフェースを提供するIteratorを生成
     *
     * @return DPIterator Iterator
     */
    #[Pure] public function iterator(): DPIterator
    {
        return new BookShelfIterator($this);
    }
}