<?php

require './ExceptionHandle.php';


/**
 * Class StringInterpolation
 */
class StringInterpolation
{
    /**
     * 错误信息
     *
     * @var string|null
     */
    public ?string $errorMessage = null;

    /**
     * 字符串需要替换变量开始标识
     *
     * @var string
     */
    public string $needleStart = '{';

    /**
     * 字符串需要替换标签结尾标识
     *
     * @var string
     */
    public string $needleEnd = '}';

    /**
     * 异常处理类
     *
     * @var ExceptionHandle|null
     */
    public ?ExceptionHandle $exception = null;

    /**
     * 构造方法
     *
     * StringInterpolation constructor.
     */
    public function __construct()
    {
        $this->exception = new ExceptionHandle();
    }

    /**
     * 渲染数据到字符串
     *
     * @param string $string
     * @param array $values
     * @return string
     * @throws Exception
     */
    public function renderString(string $string, array $values): string
    {
        $location = $this->getLocation($string);
        if ($location === null) {
            return $string;
        }

        $tag = $this->getTag($string, $location['m'], $location['n']);
        if ($tag === null) {
            $this->exception->handle($this->errorMessage);
        }

        $newString = $this->stringInterpolation($string, $location['m'], $location['n'], $tag, $values);
        if ($newString === null) {
            $this->exception->handle($this->errorMessage);
        }

        if ($this->hasNeedReplace($newString) === true) {
            return $this->renderString($newString, $values);
        } else {
            return $newString;
        }
    }

    /**
     * 检测字符串中是否还有需要替换的变量
     *
     * @param string $string
     * @return bool
     */
    public function hasNeedReplace(string $string): bool
    {
        for ($i = 0; $i <= strlen($string); $i++) {
            if (isset($string[$i])) {
                if ($string[$i] == $this->needleStart && $string[$i + 1] == $this->needleStart) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * 获取字符串中需要替换成变量的位置
     *
     * @param string $string
     * @return int[]|null
     */
    public function getLocation(string $string): ?array
    {
        $m = 0;
        $n = 0;
        $hasStart = false;
        $hasEnd = false;
        for ($i = 0; $i <= strlen($string); $i++) {
            if (isset($string[$i])) {
                if ($string[$i] == $this->needleStart && $hasStart === false) {
                    $m = $i;
                    $hasStart = true;
                }

                if ($string[$i] == $this->needleEnd && $hasEnd === false) {
                    $n = $i;
                    $hasEnd = true;
                }
            }
        }

        if ($m > 0 && $n > 0) {
            return ['m' => $m, 'n' => $n];
        }
        return null;
    }

    /**
     * 获取字符串中需要替换成变量的标签
     *
     * @param string $string
     * @param int $m
     * @param int $n
     * @return string|null
     */
    public function getTag(string $string, int $m, int $n): ?string
    {
        $tag = '';
        for ($i = 0; $i <= strlen($string); $i++) {
            if (isset($string[$i])) {
                if ($i >= $m + 2 && $i <= $n - 2) {
                    $tag .= $string[$i];
                }
            }
        }
        if (false === empty($tag)) $tag = trim($tag);
        if ($tag) return $tag;
        $this->errorMessage = 'Service processing failed.';
        return null;
    }

    /**
     * 将对应的变量插入到字符串中
     *
     * @param string $string
     * @param int $m
     * @param int $n
     * @param string $tag
     * @param array $values
     * @return string|null
     */
    public function stringInterpolation(string $string, int $m, int $n, string $tag, array $values): ?string
    {
        if (false === array_key_exists($tag, $values)) {
            $this->errorMessage = "'" . $tag . "' is not defined in 'values'.";
            return null;
        }

        $newString = '';
        $changed = false;
        for ($i = 0; $i <= strlen($string); $i++) {
            if (isset($string[$i])) {
                if ($i >= $m && $i <= $n + 1 && $this->needleStart == $string[$m]) {
                    if ($changed === false) $newString .= $values[$tag];
                    $changed = true;
                } else {
                    $newString .= $string[$i];
                }
            }
        }
        if ($newString) return $newString;
        return null;
    }
}