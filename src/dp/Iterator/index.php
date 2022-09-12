<?php

namespace app\dp\Iterator;

require_once '../../../vendor/autoload.php';

// 本棚の初期化
$bookShelf = new BookShelf();
$bookShelf->append(new Book('Around the world in 80 Days'));
$bookShelf->append(new Book('Bible'));
$bookShelf->append(new Book('Cinderella'));
$bookShelf->append(new Book('Daddy-Long-Legs'));

// 本棚から本を取り出して表示
$iterator = $bookShelf->iterator();
while ($iterator->hasNext()) {
    echo $iterator->next()->name . '</br>';
}