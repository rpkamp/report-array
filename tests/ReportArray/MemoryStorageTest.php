<?php

namespace rpkamp\ReportArray;

use PHPUnit_Framework_TestCase;

class MemoryStorageTest extends PHPUnit_Framework_TestCase
{
    public function testDefaultDefaultValue()
    {
        $storage = new MemoryStorage();
        $this->assertEquals(0, $storage->get(['foo']));
        $this->assertEquals(0, $storage->get(['foo', 'bar']));
    }

    public function testAlternaviveDefaultValue()
    {
        $storage = new MemoryStorage(5);
        $this->assertEquals(5, $storage->get(['foo']));
        $this->assertEquals(5, $storage->get(['foo', 'bar']));
    }

    public function testSet()
    {
        $storage = new MemoryStorage();
        $storage->set(['foo'], 1);
        $storage->set(['bar', 'baz'], 2);

        $this->assertEquals(['foo' => 1, 'bar' => ['baz' => 2]], $storage->getData());
    }

    public function testGet()
    {
        $storage = new MemoryStorage();
        $storage->set(['foo'], 1);
        $storage->set(['bar', 'baz'], 2);
        
        $this->assertEquals(1, $storage->get(['foo']));
        $this->assertEquals(2, $storage->get(['bar', 'baz']));
    }

    public function testNotScalar()
    {
        $storage = new MemoryStorage();
        $storage->set(['foo', 'bar'], 1);

        $this->setExpectedException('InvalidArgumentException', 'foo is not a scalar value');
        $storage->get(['foo']);
    }
}
