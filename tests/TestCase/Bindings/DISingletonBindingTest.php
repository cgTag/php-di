<?php
namespace cgTag\DI\Test\TestCase\DI\Bindings;

use cgTag\DI\Bindings\DIDynamicBinding;
use cgTag\DI\Bindings\DISingletonBinding;
use cgTag\DI\Test\BaseTestCase;

/**
 * @see \cgTag\DI\Bindings\DISingletonBinding
 */
class DISingletonBindingTest extends BaseTestCase
{

    /**
     * @test
     */
    public function shouldResolve()
    {
        $count = 0;
        $inner = new DIDynamicBinding(function () use (&$count) {
            $count++;
            return new \StdClass();
        });

        $bind = new DISingletonBinding($inner);
        $con = $this->getEmptyContainer();

        $first = $bind->resolve($con);

        for ($i = 0; $i < 10; $i++) {
            $instance = $bind->resolve($con);
            $this->assertInstanceOf(\StdClass::class, $instance);
            $this->assertSame($first, $instance);
            $this->assertSame(1, $count);
        }
    }
}
