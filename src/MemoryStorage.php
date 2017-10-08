<?php

namespace rpkamp\ReportArray;

use InvalidArgumentException;
use rpkamp\ReportArray\Interfaces\Storage;

class MemoryStorage implements Storage
{
    /**
     * @var array
     */
    private $data;

    /**
     * @var mixed
     */
    private $defaultValue;

    /**
     * @param mixed $defaultValue
     */
    public function __construct($defaultValue = 0)
    {
        $this->data = [];
        $this->defaultValue = $defaultValue;
    }

    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $index
     * @param mixed $value
     */
    public function set($index, $value): void
    {
        $last = array_pop($index);
        $arr = &$this->data;
        foreach ($index as $key) {
            if (isset($arr[$key])) {
                $arr[$key] = [];
            }
            $arr = &$arr[$key];
        }
        $arr[$last] = $value;
    }

    /**
     * @param array $index
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function get($index)
    {
        $last = array_pop($index);
        $arr = &$this->data;
        foreach ($index as $key) {
            if (array_key_exists($key, $arr)) {
                $arr = &$arr[$key];
                continue;
            }
            return $this->defaultValue;
        }
        if (isset($arr[$last])) {
            if (!is_scalar($arr[$last])) {
                throw new InvalidArgumentException(implode('.', $index).'.'.$last.' is not a scalar value');
            }
            return $arr[$last];
        }
        return $this->defaultValue;
    }
}
