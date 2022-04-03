# 概要

HTMLの各入力要素のリクエストを色々試してみる。

## ゴール

HTMLの各入力要素はリクエストでどのように表現されるのか理解することを目指す。

## チートシート

* テキスト: `name=value`の形式
* チェックボックス: `name[]=value1,name[]=value2,...`のように、チェックが付与されたもののみ送信される
* ラジオボタン: `name=value`の形式 選択された値のみが送信される
* セレクトボックス: `name=value`の形式 選択された値のみが送信される

### テキスト形式のinputの入力を受け取りたい

[参考](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/text)

```HTML
<!-- テキスト -->
<input type="text" name="text" placeholder="text">
```

```PHP
// Request Example:
// text=pompom

$rawText = $_POST['text'] ?? '';
```

### チェックボックス形式のinputの入力を受け取りたい

[配列形式でinputを受け取る参考](https://www.php.net/manual/en/faq.html.php#faq.html.arrays)
[チェックボックス参考](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/checkbox#using_checkbox_inputs)


```HTML
<!-- チェックボックス -->
<label for="Choice1">Choice1</label>
<input id="Choice1" type="checkbox" name="checkbox[]" value="choice1">
<label for="Choice2">Choice2</label>
<input id="Choice2" type="checkbox" name="checkbox[]" value="choice2">
<label for="Choice3">Choice3</label>
<input id="Choice3" type="checkbox" name="checkbox[]" value="choice3">
```

```PHP
// Request Example:
// ※%5B%5Dは[]と対応
// checkbox%5B%5D=choice1&checkbox%5B%5D=choice2
// このように、同一のname属性で複数の値が送信される

const CHOICES_CHECKBOX = ['choice1', 'choice2', 'choice3'];
$rawCheckBoxValues = $_POST['checkbox'] ?? [];
```

チェックが付与されたもののvalueのみがリクエストで送信される。
name属性は`checkbox[]`のようにチェックボックスで共通。


### ラジオボタン形式のinputの入力を受け取りたい

[参考](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/radio)

```HTML
<!-- ラジオボタン -->
<label for="Radio1">Radio1</label>
<input id="Radio1" type="radio" name="radio" value="radio1">
<label for="Radio2">Radio2</label>
<input id="Radio2" type="radio" name="radio" value="radio2">
```


```PHP
// Request Example:
// radio=radio2
const CHOICES_RADIO = ['radio1', 'radio2'];
$rawRadioButtonValue = $_POST['radio'] ?? '';
```

リクエストは`name=value`で対応。選択したものがvalueとして設定される。

### select要素の入力を受け取りたい

[参考](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/select)

```HTML
<!-- セレクトボックス -->
<select name="select">
    <option value="select1">select1</option>
    <option value="select2">select2</option>
    <option value="select3">select3</option>
    <option value="select4">select4</option>
</select>
```

```PHP
// セレクトボックス
// Request Example:
// select=select2
// name=valueで対応 選択したものがvalue値として設定される
const CHOICES_SELECT = ['select1', 'select2', 'select3', 'select4'];
$rawSelectValue = $_POST['select'] ?? '';
```