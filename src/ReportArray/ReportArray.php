<?php

namespace rpkamp\ReportArray;

use rpkamp\ReportArray\Interfaces\Storage as StorageInterface;

class ReportArray
{
    /**
     * @var StorageInterface $storage
     */
    private $storage;

    /**
     * @param StorageInterface $storage
     */
    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @return void
     */
    public function set()
    {
        $args = func_get_args();
        if (count($args) <= 1) {
            throw new \InvalidArgumentException('Need at least two parameters for ReportArray#set');
        }

        $value = array_pop($args);
        $this->storage->set($args, $value);
    }

    /**
     * @return void
     */
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

    /**
     * @return void
     */
    public function sub()
    {
        $args = func_get_args();
        if (count($args) <= 1) {
            throw new \InvalidArgumentException('Need at least two parameters for ReportArray#sub');
        }

        $value = array_pop($args);
        call_user_func_array([$this, 'add'], array_merge($args, [$value * -1]));
    }

    /**
     * @return void
     */
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

    /**
     * @return void
     */
    public function div()
    {
        $args = func_get_args();
        if (count($args) <= 1) {
            throw new \InvalidArgumentException('Need at least two parameters for ReportArray#div');
        }

        $value = array_pop($args);
        if ($value == 0) {
            throw new \InvalidArgumentException('Cannot divide by zero.');
        }
        call_user_func_array([$this, 'mul'], array_merge($args, [1 / $value]));
    }

    /**
     * @return void
     */
    public function pow()
    {
        $args = func_get_args();
        if (count($args) <= 1) {
            throw new \InvalidArgumentException('Need at least two parameters for ReportArray#pow');
        }

        $power = array_pop($args);
        $current_value = $this->storage->get($args);
        $this->storage->set($args, $current_value ** $power);
    }

    /**
     * @return void
     */
    public function root()
    {
        $args = func_get_args();
        if (count($args) <= 1) {
            throw new \InvalidArgumentException('Need at least two parameters for ReportArray#root');
        }

        $value = array_pop($args);
        if ($value == 0) {
            throw new \InvalidArgumentException('0th root does not exist');
        }
        call_user_func_array([$this, 'pow'], array_merge($args, [1 / $value]));
    }

    /**
     * @return array
     */
    public function get()
    {
        return $this->storage->getData();
    }
}
