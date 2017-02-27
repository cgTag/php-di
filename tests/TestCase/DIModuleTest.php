<?php
namespace cgTag\DI\Test\TestCase\DI;

use cgTag\DI\DIContainer;
use cgTag\DI\DIKernel;
use cgTag\DI\DIModule;
use cgTag\DI\Test\BaseTestCase;
use cgTag\DI\Test\Mocks\MockModule;
use cgTag\DI\Test\Mocks\MockModuleLoad;

/**
 * @see \cgTag\DI\DIModule
 */
class DIModuleTest extends BaseTestCase
{
    /**
     * @test
     */
    public function shouldAdd()
    {
        $m = new DIModule($this->getNoopContainer());

        $m1 = new MockModule();
        $m2 = new MockModule();
        $m3 = new MockModule();

        $m->add($m1, $m2, $m3);

        $this->assertSame(1, $m1->count);
        $this->assertSame(1, $m2->count);
        $this->assertSame(1, $m3->count);
    }

    /**
     * @test
     */
    public function shouldLoad()
    {
        $con = $this->getNoopContainer();
        $m = new MockModuleLoad($con);

        $this->assertSame(1, $m->count);
    }

    /**
     * @test
     * @expectedException \cgTag\DI\Exceptions\DIArgumentException
     * @expectedExceptionMessage not a module
     */
    public function shouldThrowWhenNotAModule()
    {
        $m = new DIModule($this->getNoopContainer());
        $m->add("foobar");
    }

    /**
     * @test
     */
    public function shouldWorkWithKernel()
    {
        $m1 = new MockModule('space', 'ship');
        $m2 = new MockModule('jack', 'rabbit');
        $m3 = new MockModule('black', 'white');

        $kernel = new DIKernel($m1, $m2, $m3);

        $this->assertSame(1, $m1->count);
        $this->assertSame(1, $m2->count);
        $this->assertSame(1, $m3->count);

        $this->assertEquals('ship', $kernel->get('space'));
        $this->assertEquals('rabbit', $kernel->get('jack'));
        $this->assertEquals('white', $kernel->get('black'));
    }
}
