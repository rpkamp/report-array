<?php

namespace rpkamp\ReportArray;

use rpkamp\ReportArray\Interfaces\Storage as StorageInterface;

class MemoryStorage implements StorageInterface
{
    /**
     * @var array
     */
    private $data;

    /**
     * @var mixed
     */
    private $default_value;

    /**
     * @param mixed $default_value
     */
    public function __construct($default_value = 0)
    {
        $this->data = [];
        $this->default_value = $default_value;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $index
     * @param mixed $value
     */
    public function set($index, $value)
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
            return $this->default_value;
        }
        if (isset($arr[$last])) {
            if (!is_scalar($arr[$last])) {
                throw new \InvalidArgumentException(implode('.', $index).'.'.$last.' is not a scalar value');
            }
            return $arr[$last];
        }
        return $this->default_value;
    }
}
