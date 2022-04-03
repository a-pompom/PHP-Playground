<?php

namespace app\simpleForm\element;

/**
 * チェックボックスを表現することを責務に持つ
 */
class CheckBox
{
    // 選択肢のチェック状態
    public array $checkState = [];
    // チェックが付与されたもの
    public array $values;

    public function __construct(array $choices, array $rawCheckedValues)
    {
        // チェックが付与された要素
        $checkedValues = array_map(function ($rawCheckedValue) {
            return htmlspecialchars($rawCheckedValue);
        }, $rawCheckedValues);
        $this->values = $checkedValues;

        // 選択肢のチェック状態
        foreach ($choices as $choice) {
            if (in_array($choice, $checkedValues)) {
                $this->checkState[$choice] = true;
                continue;
            }
            $this->checkState[$choice] = false;
        }

    }

    /**
     * 等価比較
     *
     * @param CheckBox $other 比較対象
     * @return bool 等しい->true, 等しくない->false
     */
    public function equals(CheckBox $other): bool
    {
        return $this->values === $other->values && $this->checkState === $other->checkState;
    }
}
