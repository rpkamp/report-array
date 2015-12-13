<?php

namespace rpkamp\ReportArray;

class ReportArrayTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidSet()
    {
        $arr = $this->getNewReport();
        $arr->set(1);
    }

    public function testSet()
    {
        $arr = $this->getNewReport();

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
        $arr = $this->getNewReport();
        $arr->add(1);
    }

    public function testAdd()
    {
        $arr = $this->getNewReport();

        $arr->add('foo', 1);
        $this->assertEquals(['foo' => 1], $arr->get());

        $arr->add('foo', 1);
        $this->assertEquals(['foo' => 2], $arr->get());
    }

    public function testAddNested()
    {
        $arr = $this->getNewReport();

        $arr->set('foo', 'bar', 'baz', 2);
        $arr->add('foo', 'bar', 'baz', 2);
        $this->assertEquals(['foo' => ['bar' => ['baz' => 4]]], $arr->get());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidSub()
    {
        $arr = $this->getNewReport();
        $arr->sub(1);
    }

    public function testSub()
    {
        $arr = $this->getNewReport();

        $arr->sub('foo', 1);
        $this->assertEquals(['foo' => -1], $arr->get());

        $arr->sub('foo', 1);
        $this->assertEquals(['foo' => -2], $arr->get());
    }

    public function testSubNested()
    {
        $arr = $this->getNewReport();

        $arr->set('foo', 'bar', 'baz', 2);
        $arr->sub('foo', 'bar', 'baz', 1);
        $this->assertEquals(['foo' => ['bar' => ['baz' => 1]]], $arr->get());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidMul()
    {
        $arr = $this->getNewReport();
        $arr->mul(1);
    }

    public function testMul()
    {
        $arr = $this->getNewReport();

        $arr->set('foo', 2);
        $arr->mul('foo', 2);
        $this->assertEquals(['foo' => 4], $arr->get());
    }

    public function testMulNested()
    {
        $arr = $this->getNewReport();

        $arr->set('bar', 'baz', 'ban', 2);
        $arr->mul('bar', 'baz', 'ban', 2);
        $this->assertEquals(['bar' => ['baz' => ['ban' => 4]]], $arr->get());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidDiv()
    {
        $arr = $this->getNewReport();
        $arr->div(1);
    }

    public function testDivideByZero()
    {
        $arr = $this->getNewReport();

        $this->setExpectedException('InvalidArgumentException', 'Cannot divide by zero');
        $arr->div('foo', 0);
    }

    public function testDiv()
    {
        $arr = $this->getNewReport();

        $arr->set('foo', 2);
        $arr->div('foo', 2);
        $this->assertEquals(['foo' => 1], $arr->get());
    }

    public function testDivNested()
    {
        $arr = $this->getNewReport();

        $arr->set('bar', 'baz', 'ban', 2);
        $arr->div('bar', 'baz', 'ban', 2);
        $this->assertEquals(['bar' => ['baz' => ['ban' => 1]]], $arr->get());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidPow()
    {
        $arr = $this->getNewReport();
        $arr->pow(1);
    }

    public function testPow()
    {
        $arr = $this->getNewReport();

        $arr->set('foo', 2);
        $arr->pow('foo', 3);
        $this->assertEquals(['foo' => 8], $arr->get());
    }

    public function testPowNested()
    {
        $arr = $this->getNewReport();

        $arr->set('bar', 'baz', 'ban', 2);
        $arr->pow('bar', 'baz', 'ban', 3);
        $this->assertEquals(['bar' => ['baz' => ['ban' => 8]]], $arr->get());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidRoot()
    {
        $arr = $this->getNewReport();
        $arr->root(1);
    }

    public function testZeroRoot()
    {
        $arr = $this->getNewReport();

        $arr->set('foo', 9);
        $this->setExpectedException('InvalidArgumentException', '0th root does not exist');
        $arr->root('foo', 0);
    }

    public function testRoot()
    {
        $arr = $this->getNewReport();

        $arr->set('foo', 9);
        $arr->root('foo', 2);
        $this->assertEquals(['foo' => 3], $arr->get());
    }

    public function testRootNested()
    {
        $arr = $this->getNewReport();

        $arr->set('bar', 'baz', 'ban', 9);
        $arr->root('bar', 'baz', 'ban', 2);
        $this->assertEquals(['bar' => ['baz' => ['ban' => 3]]], $arr->get());
    }

    private function getNewReport()
    {
        $storage = new Storage();
        return new ReportArray($storage);
    }
}
