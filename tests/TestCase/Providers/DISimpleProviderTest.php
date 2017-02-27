<?php
namespace cgTag\DI\Test\TestCase\DI\Providers;

use cgTag\DI\DIContainer;
use cgTag\DI\Providers\DISimpleProvider;
use cgTag\DI\Test\BaseTestCase;
use cgTag\DI\Test\Mocks\MockItem;

/**
 * @see \cgTag\DI\Providers\DISimpleProvider
 */
class DISimpleProviderTest extends BaseTestCase
{
    /**
     * @test
     */
    public function shouldWith()
    {
        $con = $this->getEmptyContainer();
        $p = new DISimpleProvider(MockItem::class);
        $this->assertInstanceOf(MockItem::class, $p->with($con, []));
        $this->assertEquals([1, 2, 3, 4], $p->with($con, [1, 2, 3, 4])->options);
    }
}
