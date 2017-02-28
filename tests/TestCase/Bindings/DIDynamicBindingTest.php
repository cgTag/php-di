<?php
namespace cgTag\DI\Test\TestCase\DI\Bindings;

use cgTag\DI\Bindings\DIDynamicBinding;
use cgTag\DI\IDIContainer;
use cgTag\DI\Test\BaseTestCase;

/**
 * @see \cgTag\DI\Bindings\DIDynamicBinding
 */
class DIDynamicBindingTest extends BaseTestCase
{
    /**
     * @test
     */
    public function shouldResolve()
    {
        $count = 0;
        $con = $this->getNoopContainer();

        $bind = new DIDynamicBinding(function ($container) use (&$count, $con) {
            $count++;
            $this->assertNotNull($container);
            $this->assertInstanceOf(IDIContainer::class, $container);
            $this->assertSame($container, $con);
            return "hello";
        });

        for ($i = 1; $i < 5; $i++) {
            $this->assertEquals("hello", $bind->resolve($con));
            $this->assertSame($i, $count);
        }
    }
}
