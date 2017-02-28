<?php
namespace cgTag\DI\Test\TestCase\DI\Bindings;

use cgTag\DI\Bindings\DILazyBinding;
use cgTag\DI\Test\BaseTestCase;

/**
 * @see \cgTag\DI\Bindings\DILazyBinding
 */
class DILazyBindingTest extends BaseTestCase
{

    /**
     * @test
     */
    public function shouldResolve()
    {
        $bind = new DILazyBinding('space');

        $con = $this->getEmptyContainer();
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
        $bind->resolve($this->getEmptyContainer());
    }
}
