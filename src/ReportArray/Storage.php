<?php

namespace rpkamp\ReportArray;

use rpkamp\ReportArray\Interfaces\Storage as StorageInterface;

class Storage implements StorageInterface
{
    private $data;

    private $default_value;

    public function __construct($default_value = 0) {
        $this->data = [];
        $this->default_value = $default_value;
    }

    public function getData()
    {
        return $this->data;
    }

    public function set($index, $value)
    {
        $last = array_pop($index);
        $arr = &$this->data;
        foreach($index as $key) {
            if (isset($arr[$key])) {
                $arr[$key] = [];
            }
            $arr = &$arr[$key];
        }
        $arr[$last] = $value;
    }

    public function get($index)
    {
        $last = array_pop($index);
        $arr = &$this->data;
        foreach($index as $key) {
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

