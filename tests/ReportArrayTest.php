<?php

namespace rpkamp\ReportArray;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ReportArrayTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_throw_exception_when_setting_value_at_root_level()
    {
        $this->expectException(InvalidArgumentException::class);
        $arr = $this->getNewReport();
        $arr->set(1);
    }

    /**
     * @test
     */
    public function it_should_correctly_set_values_in_report()
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
     * @test
     */
    public function it_should_throw_exception_when_adding_value_at_root_level()
    {
        $this->expectException(InvalidArgumentException::class);
        $arr = $this->getNewReport();
        $arr->add(1);
    }

    /**
     * @test
     */
    public function it_should_correctly_add_values_to_report()
    {
        $arr = $this->getNewReport();

        $arr->add('foo', 1);
        $this->assertEquals(['foo' => 1], $arr->get());

        $arr->add('foo', 1);
        $this->assertEquals(['foo' => 2], $arr->get());
    }

    /**
     * @test
     */
    public function it_should_correctly_add_values_in_nested_report()
    {
        $arr = $this->getNewReport();

        $arr->set('foo', 'bar', 'baz', 2);
        $arr->add('foo', 'bar', 'baz', 2);
        $this->assertEquals(['foo' => ['bar' => ['baz' => 4]]], $arr->get());
    }

    /**
     * @test
     */
    public function it_should_throw_exception_when_subtracting_value_at_root_level()
    {
        $this->expectException(InvalidArgumentException::class);
        $arr = $this->getNewReport();
        $arr->sub(1);
    }

    /**
     * @test
     */
    public function it_should_correctly_subtract_values_from_report()
    {
        $arr = $this->getNewReport();

        $arr->sub('foo', 1);
        $this->assertEquals(['foo' => -1], $arr->get());

        $arr->sub('foo', 1);
        $this->assertEquals(['foo' => -2], $arr->get());
    }

    /**
     * @test
     */
    public function it_should_correctly_subtract_values_from_nested_report()
    {
        $arr = $this->getNewReport();

        $arr->set('foo', 'bar', 'baz', 2);
        $arr->sub('foo', 'bar', 'baz', 1);
        $this->assertEquals(['foo' => ['bar' => ['baz' => 1]]], $arr->get());
    }

    /**
     * @test
     */
    public function it_should_throw_exception_when_multiplying_value_at_root_level()
    {
        $this->expectException(InvalidArgumentException::class);
        $arr = $this->getNewReport();
        $arr->mul(1);
    }

    /**
     * @test
     */
    public function it_should_correctly_multiply_values_in_report()
    {
        $arr = $this->getNewReport();

        $arr->set('foo', 2);
        $arr->mul('foo', 2);
        $this->assertEquals(['foo' => 4], $arr->get());
    }

    /**
     * @test
     */
    public function it_should_correctly_multiply_values_in_nested_report()
    {
        $arr = $this->getNewReport();

        $arr->set('bar', 'baz', 'ban', 2);
        $arr->mul('bar', 'baz', 'ban', 2);
        $this->assertEquals(['bar' => ['baz' => ['ban' => 4]]], $arr->get());
    }

    /**
     * @test
     */
    public function it_should_throw_exception_when_dividing_value_at_root_level()
    {
        $this->expectException(InvalidArgumentException::class);
        $arr = $this->getNewReport();
        $arr->div(1);
    }

    /**
     * @test
     */
    public function it_should_throw_exception_when_dividing_value_by_zero()
    {
        $arr = $this->getNewReport();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Cannot divide by zero');
        $arr->div('foo', 0);
    }

    /**
     * @test
     */
    public function it_should_correctly_divide_values_in_report()
    {
        $arr = $this->getNewReport();

        $arr->set('foo', 2);
        $arr->div('foo', 2);
        $this->assertEquals(['foo' => 1], $arr->get());
    }

    /**
     * @test
     */
    public function it_should_correctly_divide_values_in_nested_report()
    {
        $arr = $this->getNewReport();

        $arr->set('bar', 'baz', 'ban', 2);
        $arr->div('bar', 'baz', 'ban', 2);
        $this->assertEquals(['bar' => ['baz' => ['ban' => 1]]], $arr->get());
    }

    /**
     * @test
     */
    public function it_should_throw_exception_when_taking_the_power_of_value_at_root_level()
    {
        $this->expectException(InvalidArgumentException::class);
        $arr = $this->getNewReport();
        $arr->pow(1);
    }

    /**
     * @test
     */
    public function it_should_correctly_calculate_powers_in_report()
    {
        $arr = $this->getNewReport();

        $arr->set('foo', 2);
        $arr->pow('foo', 3);
        $this->assertEquals(['foo' => 8], $arr->get());
    }

    /**
     * @test
     */
    public function it_should_correctly_calculate_powers_in_nested_report()
    {
        $arr = $this->getNewReport();

        $arr->set('bar', 'baz', 'ban', 2);
        $arr->pow('bar', 'baz', 'ban', 3);
        $this->assertEquals(['bar' => ['baz' => ['ban' => 8]]], $arr->get());
    }

    /**
     * @test
     */
    public function it_should_throw_exception_when_taking_root_of_value_at_root_level()
    {
        $this->expectException(InvalidArgumentException::class);
        $arr = $this->getNewReport();
        $arr->root(1);
    }

    /**
     * @test
     */
    public function it_should_throw_exception_when_taking_zero_root_of_value()
    {
        $arr = $this->getNewReport();

        $arr->set('foo', 9);
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('0th root does not exist');
        $arr->root('foo', 0);
    }

    /**
     * @test
     */
    public function it_should_correctly_calculate_root_in_report()
    {
        $arr = $this->getNewReport();

        $arr->set('foo', 9);
        $arr->root('foo', 2);
        $this->assertEquals(['foo' => 3], $arr->get());
    }

    /**
     * @test
     */
    public function it_should_correctly_calculate_root_in_nested_report()
    {
        $arr = $this->getNewReport();

        $arr->set('bar', 'baz', 'ban', 9);
        $arr->root('bar', 'baz', 'ban', 2);
        $this->assertEquals(['bar' => ['baz' => ['ban' => 3]]], $arr->get());
    }

    private function getNewReport()
    {
        $storage = new MemoryStorage();
        return new ReportArray($storage);
    }
}
