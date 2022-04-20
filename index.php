<?php

/**
 * PHP > 7.4
 * php /... you path .../string-interpolation/index.php
 * php /... you path .../string-interpolation/test.php
 */

require 'StringInterpolation.php';

$task = new StringInterpolation();

// 1、有标签需要替换，返回替换之后的字符串。
//$string = 'Say hello to {{ name }}. He is {{ age }}.';
//$values = ['name' => 'Lu', 'age' => 19];

// 2、有标签需要替换，values 中多余给出来的值不做任何处理。
//$string = 'Say hello to {{ name }}. He is {{ age }}.';
//$values = ['name' => 'Lu', 'age' => 18, 'male' => true];

// 3、有标签需要替换，但是给定的 values 值中缺少对应的参数，会抛出异常。
//$string = 'Tommy is a good friend of {{ name }}. He lives in {{ city }}.';
//$values = ['name' => 'Lu'];

// 4、判断没有标签需要替换直接输出结果
//$string = 'Hello, my name is Lu and I live in Chengdu.';
//$values = ['name' => 'Lu'];

// 4、不一样的变量名也同样兼容
$string = 'The next F1 race will be in {{ city }} on {{ date }}.';
$values = ['city' => 'Melbourne', 'date' => '2022-04-08'];

try {
    $response = $task->renderString($string, $values);
    echo $response . PHP_EOL;
} catch (Exception $e) {
    echo $e . PHP_EOL;
}

