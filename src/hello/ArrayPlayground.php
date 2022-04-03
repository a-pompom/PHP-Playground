<?php

namespace app\hello;

/*
 * 配列検証用
 */

use JetBrains\PhpStorm\ArrayShape;

class ArrayPlayground
{
    /**
     * インデックス形式の配列を取得
     *
     * @return int[] インデックスが数値の配列
     */
    public function getIndexedArray(): array
    {
        return [1, 2, 3, 4, 5];
    }

    /**
     * 連想配列を取得
     *
     * @return string[] 連想配列
     */
    #[ArrayShape(['pom' => "string", 'pudding' => "string"])]
    public function getAssociativeArray(): array
    {
        return [
            'pom' => 'pom',
            'pudding' => 'pudding'
        ];
    }
}