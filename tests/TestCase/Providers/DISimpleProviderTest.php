<?php
namespace cgTag\DI\Test\TestCase\DI\Providers;

use cgTag\DI\DIContainer;
use cgTag\DI\Providers\DISimpleProvider;
use cgTag\DI\Test\Mocks\MockItem;
use PHPUnit\Framework\TestCase;

/**
 * @see \cgTag\DI\Providers\DISimpleProvider
 */
class DISimpleProviderTest extends TestCase
{
    /**
     * @test
     */
    public function shouldWith()
    {
        $p = new DISimpleProvider(MockItem::class);
        $this->assertInstanceOf(MockItem::class, $p->with(new DIContainer(), []));
        $this->assertEquals([1, 2, 3, 4], $p->with(new DIContainer(), [1, 2, 3, 4])->options);
    }
}
