<?php

namespace app\dp\Iterator;

/**
 * 集合体を表現することを責務に持つ
 */
interface Aggregate
{
    /**
     * 反復処理のためのIteratorを生成
     *
     * @return DPIterator Iteratorオブジェクト
     */
    public function iterator(): DPIterator;
}