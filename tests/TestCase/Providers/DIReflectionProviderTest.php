<?php
namespace cgTag\DI\Test\TestCase\DI\Providers;

use cgTag\DI\Providers\DIReflectionProvider;
use cgTag\DI\Test\BaseTestCase;
use cgTag\DI\Test\Mocks\MockItem;

/**
 * @see \cgTag\DI\Providers\DIReflectionProvider
 */
class DIReflectionProviderTest extends BaseTestCase
{
    /**
     * @test
     */
    public function shouldCreate()
    {
        $con = $this->getEmptyContainer();
        $con->bind('options')->toArray([1, 2, 3, 4]);

        $p = new DIReflectionProvider(MockItem::class);

        $this->assertInstanceOf(MockItem::class, $p->create($con));
        $this->assertEquals([1, 2, 3, 4], $p->create($con)->options);
    }
}
