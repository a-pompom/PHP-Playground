<?php

namespace app\simpleForm\element;

/**
 * input type="text"のvalue値を保持することを責務に持つ
 */
class TextInput
{
    // 入力値
    public string $value;

    public function __construct(string $rawValue)
    {
        $this->value = htmlspecialchars($rawValue);
    }

    /**
     * 等価比較
     *
     * @param TextInput $other 比較対象
     * @return bool 等しい-> true, 等しくない-> false
     */
    public function equals(TextInput $other): bool
    {
        return $this->value === $other->value;
    }
}