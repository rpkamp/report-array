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

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidAdd()
    {
        $arr = new ReportArray();
        $arr->add(1);
    }

    public function testIllegalAdd()
    {
        $arr = new ReportArray();
        $arr->set('foo', 'bar', 1);

        $this->setExpectedException('InvalidArgumentException', 'foo is not a scalar value');
        $arr->add('foo', 1);
    }

    public function testAdd()
    {
        $arr = new ReportArray();

        $arr->add('foo', 1);
        $this->assertEquals(['foo' => 1], $arr->get());

        $arr->add('foo', 1);
        $this->assertEquals(['foo' => 2], $arr->get());
    }

    public function testAddNested()
    {
        $arr = new ReportArray();

        $arr->set('foo', 'bar', 'baz', 2);
        $arr->add('foo', 'bar', 'baz', 2);
        $this->assertEquals(['foo' => ['bar' => ['baz' => 4]]], $arr->get());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidMul()
    {
        $arr = new ReportArray();
        $arr->mul(1);
    }

    public function testIllegalMul()
    {
        $arr = new ReportArray();
        $arr->set('foo', 'bar', 1);

        $this->setExpectedException('InvalidArgumentException', 'foo is not a scalar value');
        $arr->mul('foo', 2);
    }

    public function testMul()
    {
        $arr = new ReportArray();

        $arr->set('foo', 2);
        $arr->mul('foo', 2);
        $this->assertEquals(['foo' => 4], $arr->get());
    }

    public function testMulNested()
    {
        $arr = new ReportArray();

        $arr->set('bar', 'baz', 'ban', 2);
        $arr->mul('bar', 'baz', 'ban', 2);
        $this->assertEquals(['bar' => ['baz' => ['ban' => 4]]], $arr->get());
    }
}
