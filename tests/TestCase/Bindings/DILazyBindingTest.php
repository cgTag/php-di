<?php
namespace cgTag\DI\Test\TestCase\DI\Bindings;

use cgTag\DI\Bindings\DILazyBinding;
use cgTag\DI\DIContainer;
use PHPUnit\Framework\TestCase;

/**
 * @see \cgTag\DI\Bindings\DILazyBinding
 */
class DILazyBindingTest extends TestCase
{

    /**
     * @test
     */
    public function shouldResolve()
    {
        $bind = new DILazyBinding('space');

        $con = new DIContainer();
        $con->bind('space')->toConstant('ship');

        $this->assertEquals('ship', $bind->resolve($con));
    }

    /**
     * @test
     * @expectedException \cgTag\DI\Exceptions\DINotFoundException
     * @expectedExceptionMessage Injectable not found: space
     */
    public function shouldThrowDependencyNotFound()
    {
        $bind = new DILazyBinding('space');
        $bind->resolve(new DIContainer());
    }
}
