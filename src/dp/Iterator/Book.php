<?php

namespace app\dp\Iterator;

/**
 * 本棚の構成要素である本を表現することを責務に持つ
 */
class Book
{
    // 本のタイトル
    public string $name;

    public function __construct($name)
    {
        $this->name = $name;
    }
}
