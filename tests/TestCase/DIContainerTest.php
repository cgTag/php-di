<?php
namespace cgTag\DI\Test\TestCase\DI;

use cgTag\DI\Bindings\DIConstantBinding;
use cgTag\DI\DIContainer;
use cgTag\DI\IDIContainer;
use cgTag\DI\IDICreator;
use cgTag\DI\Syntax\DIBindTo;
use cgTag\DI\Test\BaseTestCase;
use cgTag\DI\Test\Mocks\MockItem;
use cgTag\DI\Test\Mocks\MockItemProvider;

/**
 * @see \cgTag\DI\DIContainer
 */
class DIContainerTest extends BaseTestCase
{
    /**
     * @test
     */
    public function shouldBind()
    {
        $con = $this->getEmptyContainer();
        /** @var DIBindTo $bind */
        $bind = $con->bind('space');

        $this->assertInstanceOf(DIBindTo::class, $bind);
        $this->assertSame($con, $bind->container);
    }

    /**
     * @test
     */
    public function shouldGet()
    {
        $con = $this->getEmptyContainer();
        $con->bind('space')->toConstant('ship');
        $this->assertEquals('ship', $con->get('space'));
    }

    /**
     * @test
     */
    public function shouldGetBinding()
    {
        $con = $this->getEmptyContainer();
        $bind = $con->bind('space');

        $this->assertNull($con->getBinding('space'));

        $bind->toConstant('ship');
        $this->assertNotNull($con->getBinding('space'));
        $this->assertInstanceOf(DIConstantBinding::class, $con->getBinding('space'));
    }

    /**
     * @test
     */
    public function shouldGetByInjectingConstants()
    {
        $con = $this->getEmptyContainer();
        $count = 0;

        $con->bind('space')->toDynamic(function (IDIContainer $con) use (&$count) {
            $count++;
            $this->assertEquals('house', $con->get('one'));
            $this->assertEquals('dog', $con->get('two'));
            $this->assertEquals('cat', $con->get('three'));
            return 'ship';
        });

        $resolved = $con->get('space', [
            'one' => 'house',
            'two' => 'dog',
            'three' => 'cat'
        ]);

        $this->assertSame('ship', $resolved);
        $this->assertSame(1, $count);
    }

    /**
     * @test
     */
    public function shouldGetContainer()
    {
        $con = $this->getEmptyContainer();
        $this->assertSame($con, $con->getContainer());
    }

    /**
     * @test
     */
    public function shouldGetParent()
    {
        $con = $this->getEmptyContainer();
        $this->assertSame(
            $con,
            $this->getWIthParentContainer($con)->getParent()
        );
    }

    /**
     * @test
     */
    public function shouldGetRoot()
    {
        $con1 = $this->getEmptyContainer();
        $con2 = $this->getWIthParentContainer($con1);
        $this->assertSame($con1, $con1->getRoot());
        $this->assertSame($con1, $con2->getRoot());
    }

    /**
     * @test
     * @expectedException \cgTag\DI\Exceptions\DIArgumentException
     * @expectedExceptionMessage invalid symbol for constant
     */
    public function shouldGetThrowArgumentException()
    {
        $con = $this->getEmptyContainer();
        $con->get('space', ['foo']);
    }

    /**
     * @test
     */
    public function shouldHas()
    {
        $con = $this->getEmptyContainer();
        $this->assertFalse($con->has('space'));
        $con->bind('space')->toConstant('ship');
        $this->assertTrue($con->has('space'));
    }

    /**
     * @test
     * @expectedException \cgTag\DI\Exceptions\DINotFoundException
     * @expectedExceptionMessage Injectable not found: space
     *
     */
    public function shouldHaveGetThrowDependencyNotFound()
    {
        $con = $this->getEmptyContainer();
        $con->get('space');
    }

    /**
     * @test
     */
    public function shouldHaveNoParent()
    {
        $con = $this->getEmptyContainer();
        $this->assertNull($con->getParent());
        $this->assertSame($con, $con->getRoot());
    }

    /**
     * @test
     */
    public function shouldHaveNullParent()
    {
        $this->assertNull($this->getEmptyContainer()->getParent());
    }

    /**
     * @test
     */
    public function shouldIsRoot()
    {
        $con1 = $this->getEmptyContainer();
        $con2 = $this->getWIthParentContainer($con1);
        $this->assertTrue($con1->isRoot());
        $this->assertFalse($con2->isRoot());
    }

    /**
     * @test
     */
    public function shouldIsolate()
    {
        $con1 = $this->getEmptyContainer();
        $con1->bind('space')->toConstant('ship');
        $con2 = $con1->isolate();

        $this->assertSame($con1, $con2->getParent());
        $this->assertInstanceOf(DIContainer::class, $con2);

        $this->assertTrue($con2->has('space'));
        $this->assertEquals('ship', $con2->get('space'));

        $con2->bind('space')->toConstant('maker');
        $this->assertTrue($con2->has('space'));
        $this->assertEquals('maker', $con2->get('space'));
    }

    /**
     * @test
     */
    public function shouldSetBinding()
    {
        $con = $this->getEmptyContainer();
        $bind1 = $this->getMockBinding();
        $bind2 = $this->getMockBinding();

        $con->setBinding('space', $bind1);
        $this->assertSame($bind1, $con->getBinding('space'));

        $con->setBinding('space', $bind2, true);
        $this->assertSame($bind2, $con->getBinding('space'));
    }

    /**
     * @test
     */
    public function shouldTakeAParent()
    {
        $con1 = $this->getEmptyContainer();
        $con2 = $this->getWIthParentContainer($con1);

        $this->assertSame($con1, $con2->getParent());
        $this->assertSame($con1, $con2->getRoot());
    }

    /**
     * @test
     * @expectedException \cgTag\DI\Exceptions\DIDuplicateException
     * @expectedExceptionMessage Duplicate binding for: space
     */
    public function shouldThrowDependencyDuplicateException()
    {
        $con = $this->getEmptyContainer();
        $con->setBinding('space', $this->getMockBinding());
        $con->setBinding('space', $this->getMockBinding());
    }
}
