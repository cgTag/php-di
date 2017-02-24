<?php
namespace cgTag\DI\Test\TestCase\DI\Bindings;

use cgTag\DI\Bindings\DIDynamicBinding;
use cgTag\DI\DIContainer;
use cgTag\DI\IDIContainer;
use PHPUnit\Framework\TestCase;

/**
 * @see \cgTag\DI\Bindings\DIDynamicBinding
 */
class DIDynamicBindingTest extends TestCase
{
    /**
     * @test
     */
    public function shouldResolve()
    {
        $count = 0;
        $con = new DIContainer();

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
