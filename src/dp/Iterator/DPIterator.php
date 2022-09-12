<?php

namespace app\dp\Iterator;
/**
 * 集合体を操作する機能を提供することを責務に持つ
 */
interface DPIterator
{
    /**
     * 次の要素が存在するか
     * @return bool 存在する->true, 存在しない->false
     */
    public function hasNext(): bool;

    /**
     * 参照を1つ先の要素へ進め、現在の要素を返却
     * @return object 現在参照している要素
     */
    public function next(): object;
}