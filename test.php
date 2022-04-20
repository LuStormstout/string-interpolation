<?php

require 'StringInterpolation.php';
$task = new StringInterpolation();

/**
 * 测试数据
 */
$testData = [
    [
        'string' => 'Hello, my name is Lu and I live in Chengdu.',
        'values' => ['name' => 'Zhang'],
        'message' => '1、字符串中没有标签需要替换，直接输出结果。 ✅'
    ],
    [
        'string' => 'Say hello to {{ name }}. He is {{ age }}.',
        'values' => ['name' => 'Lu', 'age' => 19],
        'message' => '2、字符串中有标签需要替换，返回替换之后的字符串。 ✅'
    ],
    [
        'string' => 'Say hello to {{ name }}. He is {{ age }}.',
        'values' => ['name' => 'Lu', 'age' => 18, 'male' => true],
        'message' => '3、字符串中有标签需要替换，values 中多余给出来的值不做任何处理。 ✅'
    ],
    [
        'string' => 'The next F1 race will be in {{ city }} on {{ date }}.',
        'values' => ['city' => 'Melbourne', 'date' => '2022-04-08'],
        'message' => '4、给定不一样的变量名也同样兼容。 ✅'
    ],
    [
        'string' => 'The next F1 race will be in {{ city }} on {{ date }}.',
        'values' => ['city' => 'Melbourne'],
        'message' => '5、字符串中有标签需要替换，但是给定的 values 值中缺少对应的参数，会抛出异常。 ❌'
    ]
];

echo "「开始测试字符串变量插入功能...」" . PHP_EOL;

foreach ($testData as $item) {
    try {
        echo '正在执行：' . $item['message'] . PHP_EOL;
        echo '字符串：：' . $item['string'] . PHP_EOL;
        echo 'values：' . json_encode($item['values']) . PHP_EOL;
        $response = $task->renderString($item['string'], $item['values']);
        echo '结果：' . $response . PHP_EOL;
        echo PHP_EOL;
    } catch (Exception $e) {
        echo $e . PHP_EOL;
    }
}

