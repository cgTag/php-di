<?php
namespace cgTag\DI\Test\TestCase;

use cgTag\DI\DIKernel;
use cgTag\DI\IDIContainer;
use cgTag\DI\IDIModule;
use cgTag\DI\Test\BaseTestCase;

class DIKernelTest extends BaseTestCase
{
    /**
     * @return IDIModule
     */
    public function getMockModule(): IDIModule
    {
        /** @var IDIModule|\PHPUnit_Framework_MockObject_MockObject $mock */
        $mock = $this->getMockBuilder(IDIModule::class)
            ->setMethods(['load'])
            ->getMock();

        $mock->expects($this->once())
            ->method('load')
            ->with($this->isInstanceOf(IDIContainer::class));

        return $mock;
    }
    
    /**
     * @test
     */
    public function shouldLoadManyModules()
    {
        $mod1 = $this->getMockModule();
        $mod2 = $this->getMockModule();
        $mod3 = $this->getMockModule();
        $mod4 = $this->getMockModule();

        new DIKernel($mod1, $mod2, $mod3, $mod4);
    }

    /**
     * @test
     */
    public function shouldLoadOneModule()
    {
        $mock = $this->getMockBuilder(IDIModule::class)
            ->setMethods(['load'])
            ->getMock();

        $mock->expects($this->once())
            ->method('load')
            ->with($this->isInstanceOf(IDIContainer::class));

        $kernel = new DIKernel($mock);
    }

    /**
     * @test
     */
    public function shouldSupportEmptyKernel()
    {
        $kernel = new DIKernel();

        $this->assertInstanceOf(IDIContainer::class, $kernel->getContainer());
        $this->assertSame($kernel->getContainer(), $kernel->getContainer()->getRoot());
    }
}