# Static Array

A static array that can only contain items of a single type and has a fixed size.

## Installation

```
composer require henrikac/static-array
```

## Usage

#### Basic usage
```php
<?php

use Henrikac\StaticArray\StaticArray;

$arr = new StaticArray(int::class, 10);

$arr[0] = 18;
$arr[1] = 3;
$arr[2] = 43;

$arr->getSize(); // => 10

count($arr); // => 3

foreach ($arr as $num) {
    echo $num . PHP_EOL;
}

// output:
// 18
// 3
// 43
```

PHP built-in arrays allow the user to do `$arr[] = 15;` when they want to add an item.
This is, however, not allowed with `StaticArray`.
It requires you to specify the index where you want to insert the item.

