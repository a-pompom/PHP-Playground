<?php
namespace app\simpleForm;

use app\simpleForm\element\CheckBox;
use app\simpleForm\element\Select;
use app\simpleForm\element\TextInput;
use app\simpleForm\element\RadioButton;

require_once $_SERVER['DOCUMENT_ROOT'] . '/playground/vendor/autoload.php';

// テキスト入力
// request example:
// text=pompom
$rawText = $_POST['text'] ?? '';
$textInput = new TextInput($rawText);

// チェックボックス
// Request Example:
// ※%5B%5Dは[]と対応
// checkbox%5B%5D=choice1&checkbox%5B%5D=choice2
// このように、同一のname属性で複数の値が送信される
const CHOICES_CHECKBOX = ['choice1', 'choice2', 'choice3'];
$rawCheckBoxValues = $_POST['checkbox'] ?? [];
$checkbox = new CheckBox(CHOICES_CHECKBOX, $rawCheckBoxValues);

// ラジオボタン
// Request Example:
// radio=radio2
// name=valueで対応 選択したものがvalue値として設定される
const CHOICES_RADIO = ['radio1', 'radio2'];
$rawRadioButtonValue = $_POST['radio'] ?? '';
$radioButton = new RadioButton(CHOICES_RADIO, $rawRadioButtonValue);

// セレクトボックス
// Request Example:
// select=select2
// name=valueで対応 選択したものがvalue値として設定される
const CHOICES_SELECT = ['select1', 'select2', 'select3', 'select4'];
$rawSelectValue = $_POST['select'] ?? '';
$select = new Select(CHOICES_SELECT, $rawSelectValue);

$context = [
    'text' => $textInput->value,
    'checkbox' => $checkbox->values,
    'radio' => $radioButton->selected,
    'select' => $select->selected,
];

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Form Sample Result</title>
</head>
<body>
<div>
    <h1>Result</h1>
    <h4>Text</h4>
    <p>
        <?=$context['text']?>
    </p>
    <hr>
    <h4>Checkbox</h4>
    <?php foreach ($context['checkbox'] as $checked) : ?>
        <p><?=$checked?></p>
    <?php endforeach; ?>

    <hr>

    <h4>Radio Button</h4>
    <p><?=$context['radio']?></p>

    <hr>

    <h4>Select</h4>
    <p><?=$context['select']?></p>
</div>
</body>
</html>

