<?php

namespace app\simpleForm\element;

class Select
{
    /**
     * 選択値
     * @var string
     */
    public string $selected;
    // 未選択を表現
    const NOTHING_SELECTED = '';

    /**
     * @param array $choices 選択肢
     * @param string $selected 選択値
     */
    public function __construct(array $choices, string $selected)
    {
        if (!in_array($selected, $choices)) {
            $this->selected = self::NOTHING_SELECTED;
            return;
        }
        $this->selected = htmlspecialchars($selected);
    }
}
