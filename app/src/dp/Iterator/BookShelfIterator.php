<?php

namespace app\dp\Iterator;

use JetBrains\PhpStorm\Pure;

/**
 * 本棚を反復する機能を提供することを責務に持つ
 */
class BookShelfIterator implements DPIterator
{
    // 反復対象の本棚
    private BookShelf $bookShelf;
    // Iteratorが現在参照している位置
    private int $index;

    public function __construct(BookShelf $bookShelf)
    {
        $this->bookShelf = $bookShelf;
        $this->index = 0;
    }

    /**
     * 反復対象に次の要素が存在するか判定
     *
     * ループ処理を打ち切るか判定するために利用
     *
     * @return bool 存在->true, 存在しない->false
     */
    #[Pure] public function hasNext(): bool
    {
        return $this->index < $this->bookShelf->size();
    }

    /**
     * 現在参照している要素を返却
     *
     * あわせて、参照している位置を1つ先へ進める
     *
     * @return Book 現在参照している本
     */
    public function next(): Book
    {
        $current = $this->bookShelf->take($this->index);
        $this->index++;

        return $current;
    }
}