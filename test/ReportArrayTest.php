<?php

namespace rpkamp\ReportArray\test;

use rpkamp\ReportArray\ReportArray;

class ReportArrayTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidSet()
    {
        $arr = new ReportArray();
        $arr->set(1);
    }

    public function testSet()
    {
        $arr = new ReportArray();

        $arr->set('foo', 8);
        $this->assertEquals(['foo' => 8], $arr->get());

        $arr->set('baz', 10);
        $this->assertEquals(['foo' => 8, 'baz' => 10], $arr->get());

        $arr->set('ban', 'bar', 2);
        $this->assertEquals(['foo' => 8, 'baz' => 10, 'ban' => ['bar' => 2]], $arr->get());
    }

}
