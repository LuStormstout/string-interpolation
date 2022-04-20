### 在不使用 PHP 自带的字符串处理函数的情况下实现「模板标签渲染」功能

***

#### info

- 需要渲染的字符串 `The next F1 race will be in {{ city }} on {{ date }}.`
- 给定的变量值 `['city' => 'Melbourne', 'date' => '2022-04-08']`
- 执行结果 `The next F1 race will be in Melbourne on 2022-04-08.`

***    

#### run

`php /... you path .../string-interpolation/index.php`

`php /... you path .../string-interpolation/test.php`

***

#### env

- PHP > 7.4