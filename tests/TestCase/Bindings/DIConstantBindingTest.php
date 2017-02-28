<?php
namespace cgTag\DI\Test\TestCase\DI\Bindings;

use cgTag\DI\Bindings\DIConstantBinding;
use cgTag\DI\Test\BaseTestCase;

/**
 * @see \cgTag\DI\Bindings\DIConstantBinding
 */
class DIConstantBindingTest extends BaseTestCase
{
    /**
     * @test
     */
    public function shouldAllowNull()
    {
        $bind = new DIConstantBinding(null);
        $this->assertNull($bind->resolve($this->getNoopContainer()));
    }

    /**
     * @test
     */
    public function shouldResolve()
    {
        $bind = new DIConstantBinding("hello");
        $this->assertEquals("hello", $bind->resolve($this->getNoopContainer()));
    }
}
