<?php

namespace rpkamp\ReportArray;

class ReportArray
{
    private $data;

    public function __construct($defaultValue = 0) {
        $this->data = [];
    }

    public function set()
    {
        $args = func_get_args();
        if (count($args) <= 1) {
            throw new \InvalidArgumentException('Need at least two parameters for ReportArray#set');
        }

        $value = array_pop($args);
        $this->setValue($args, $value);
    }

    public function get()
    {
        return $this->data;
    }

    private function setValue($args, $value)
    {
        $last = array_pop($args);
        $arr = &$this->data;
        foreach($args as $key) {
            if (isset($arr[$key])) {
                $arr[$key] = [];
            }
            $arr = &$arr[$key];
        }
        $arr[$last] = $value;
    }
}

