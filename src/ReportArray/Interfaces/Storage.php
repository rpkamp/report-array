<?php

namespace rpkamp\ReportArray\Interfaces;

interface Storage
{
    public function get($index);
    public function set($index, $value);
    public function getData();
}