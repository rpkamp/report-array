<?php

namespace rpkamp\ReportArray;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class MemoryStorageTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_return_zero_when_no_custom_default_value_provided()
    {
        $storage = new MemoryStorage();
        $this->assertEquals(0, $storage->get(['foo']));
        $this->assertEquals(0, $storage->get(['foo', 'bar']));
    }

    /**
     * @test
     */
    public function it_should_return_custom_default_value_when_provided()
    {
        $storage = new MemoryStorage(5);
        $this->assertEquals(5, $storage->get(['foo']));
        $this->assertEquals(5, $storage->get(['foo', 'bar']));
    }

    /**
     * @test
     */
    public function it_should_store_data_constructed_by_set_calls()
    {
        $storage = new MemoryStorage();
        $storage->set(['foo'], 1);
        $storage->set(['bar', 'baz'], 2);

        $this->assertEquals(['foo' => 1, 'bar' => ['baz' => 2]], $storage->getData());
    }

    /**
     * @test
     */
    public function it_should_return_values_from_stored_data()
    {
        $storage = new MemoryStorage();
        $storage->set(['foo'], 1);
        $storage->set(['bar', 'baz'], 2);
        
        $this->assertEquals(1, $storage->get(['foo']));
        $this->assertEquals(2, $storage->get(['bar', 'baz']));
    }

    /**
     * @test
     */
    public function it_should_throw_exception_when_requesting_non_scalar_value()
    {
        $storage = new MemoryStorage();
        $storage->set(['foo', 'bar'], 1);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('foo is not a scalar value');
        $storage->get(['foo']);
    }
}
