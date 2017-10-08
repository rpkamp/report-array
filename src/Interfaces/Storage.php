<?php

namespace rpkamp\ReportArray\Interfaces;

interface Storage
{
    /**
     * @param array $index
     * @return mixed
     */
    public function get($index);

    /**
     * @param array $index
     * @param mixed $value
     * @return void
     */
    public function set($index, $value);

    /**
     * @return array
     */
    public function getData();
}
