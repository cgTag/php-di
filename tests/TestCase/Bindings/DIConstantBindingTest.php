<?php
namespace cgTag\DI\Test\TestCase\DI\Bindings;

use cgTag\DI\Bindings\DIConstantBinding;
use cgTag\DI\DIContainer;
use PHPUnit\Framework\TestCase;

/**
 * @see \cgTag\DI\Bindings\DIConstantBinding
 */
class DIConstantBindingTest extends TestCase
{
    /**
     * @test
     */
    public function shouldResolve()
    {
        $bind = new DIConstantBinding("hello");
        $this->assertEquals("hello", $bind->resolve(new DIContainer()));
    }

    /**
     * @test
     */
    public function shouldAllowNull()
    {
        $bind = new DIConstantBinding(null);
        $this->assertNull($bind->resolve(new DIContainer()));
    }
}
