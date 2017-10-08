<?php

namespace rpkamp\ReportArray;

use rpkamp\ReportArray\Interfaces\Storage as StorageInterface;

/**
 * @method void set(...$arguments)
 * @method void add(...$arguments)
 * @method void sub(...$arguments)
 * @method void mul(...$arguments)
 * @method void div(...$arguments)
 * @method void pow(...$arguments)
 * @method void root(...$arguments)
 */
class ReportArray
{
    /**
     * @var StorageInterface $storage
     */
    private $storage;

    /**
     * @var callback[]
     */
    private $methods;

    /**
     * @param StorageInterface $storage
     */
    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;

        $this->addMethod('set', function ($_, $value) {
            return $value;
        });
        $this->addMethod('add', function ($carry, $value) {
            return $carry + $value;
        });
        $this->addMethod('sub', function ($carry, $value) {
            return $carry - $value;
        });
        $this->addMethod('mul', function ($carry, $value) {
            return $carry * $value;
        });
        $this->addMethod('div', function ($carry, $value) {
            if ($value == 0) {
                throw new \InvalidArgumentException('Cannot divide by zero.');
            }
            return $carry / $value;
        });
        $this->addMethod('pow', function ($carry, $value) {
            return $carry ** $value;
        });
        $this->addMethod('root', function ($carry, $value) {
            if ($value == 0) {
                throw new \InvalidArgumentException('0th root does not exist');
            }
            return $carry ** (1/$value);
        });
    }

    public function addMethod(string $name, callable $strategy): void
    {
        if (method_exists($this, $name)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Method %s is already defined on %s - unable to override using __call',
                    $name,
                    get_class($this)
                )
            );
        }
        $this->methods[$name] = $strategy;
    }

    public function __call(string $method, array $arguments): void
    {
        if (!array_key_exists($method, $this->methods)) {
            throw new \RuntimeException('Call to non-existing method ReportArray#'.$method);
        }

        if (count($arguments) <= 1) {
            throw new \InvalidArgumentException('Need at least two parameters for ReportArray#'.$method);
        }

        $value = array_pop($arguments);
        $this->storage->set($arguments, $this->methods[$method]($this->storage->get($arguments), $value));
    }

    public function get(): array
    {
        return $this->storage->getData();
    }
}
