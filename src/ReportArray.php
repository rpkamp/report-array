<?php

namespace rpkamp\ReportArray;

class ReportArray
{
    private $storage;

    public function __construct($default_value = 0) {
        $this->storage = new Storage($default_value);
    }

    public function set()
    {
        $args = func_get_args();
        if (count($args) <= 1) {
            throw new \InvalidArgumentException('Need at least two parameters for ReportArray#set');
        }

        $value = array_pop($args);
        $this->storage->set($args, $value);
    }

    public function add()
    {
        $args = func_get_args();
        if (count($args) <= 1) {
            throw new \InvalidArgumentException('Need at least two parameters for ReportArray#add');
        }

        $add = array_pop($args);
        $current_value = $this->storage->get($args);
        $this->storage->set($args, $current_value + $add);
    }

    public function mul()
    {
        $args = func_get_args();
        if (count($args) <= 1) {
            throw new \InvalidArgumentException('Need at least two parameters for ReportArray#mul');
        }

        $mul = array_pop($args);
        $current_value = $this->storage->get($args);
        $this->storage->set($args, $current_value * $mul); 
    }

    public function get()
    {
        return $this->storage->getData();
    }
}

