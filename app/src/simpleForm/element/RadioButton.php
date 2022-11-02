<?php
namespace app\simpleForm\element;

/**
 * ラジオボタンを表現することを責務に持つ
 */
class RadioButton
{
    const NOTHING_SELECTED = '';
    public string $selected;

    /**
     * @param array $choices ラジオボタンの選択肢
     * @param string $selected 選択値
     */
    public function __construct(array $choices, string $selected)
    {
        // 選択値が選択肢に含まれない
        if (! in_array($selected, $choices)) {
            $this->selected = self::NOTHING_SELECTED;
            return;
        }

        $this->selected = htmlspecialchars($selected);
    }
}
