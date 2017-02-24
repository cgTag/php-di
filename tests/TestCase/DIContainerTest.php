<?php
namespace cgTag\DI\Test\TestCase\DI;

use cgTag\DI\Bindings\DIConstantBinding;
use cgTag\DI\DIContainer;
use cgTag\DI\IDIContainer;
use cgTag\DI\IDICreator;
use cgTag\DI\Syntax\DIBindTo;
use cgTag\DI\Test\Mocks\MockItem;
use cgTag\DI\Test\Mocks\MockItemProvider;
use PHPUnit\Framework\TestCase;

/**
 * @see \cgTag\DI\DIContainer
 */
class DIContainerTest extends TestCase
{
    /**
     * @test
     */
    public function shouldBind()
    {
        $con = new DIContainer();
        /** @var DIBindTo $bind */
        $bind = $con->bind('space');

        $this->assertInstanceOf(DIBindTo::class, $bind);
        $this->assertSame($con, $bind->container);
    }

    /**
     * @test
     */
    public function shouldCreate()
    {
        $con = new DIContainer();
        $con->bind(MockItem::class)->withProvider(new MockItemProvider());
        $item = $con->create(MockItem::class);
        $this->assertInstanceOf(MockItem::class, $item);
    }

    /**
     * @test
     */
    public function shouldGet()
    {
        $con = new DIContainer();
        $con->bind('space')->toConstant('ship');
        $this->assertEquals('ship', $con->get('space'));
    }

    /**
     * @test
     */
    public function shouldGetBinding()
    {
        $con = new DIContainer();
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
        $con = new DIContainer();
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
        $con1 = new DIContainer();
        $this->assertSame($con1, $con1->getContainer());
    }

    /**
     * @test
     */
    public function shouldGetParent()
    {
        $con1 = new DIContainer();
        $this->assertNull((new DIContainer())->getParent());
        $this->assertSame($con1, (new DIContainer($con1))->getParent());
    }

    /**
     * @test
     */
    public function shouldGetRoot()
    {
        $con1 = new DIContainer();
        $con2 = new DIContainer($con1);
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
        $con = new DIContainer();
        $con->get('space', ['foo']);
    }

    /**
     * @test
     */
    public function shouldHas()
    {
        $con = new DIContainer();
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
        $con = new DIContainer();
        $con->get('space');
    }

    /**
     * @test
     */
    public function shouldHaveNoParent()
    {
        $con = new DIContainer();
        $this->assertNull($con->getParent());
        $this->assertSame($con, $con->getRoot());
    }

    /**
     * @test
     */
    public function shouldIsRoot()
    {
        $con1 = new DIContainer();
        $con2 = new DIContainer($con1);
        $this->assertTrue($con1->isRoot());
        $this->assertFalse($con2->isRoot());
    }

    /**
     * @test
     */
    public function shouldIsolate()
    {
        $con1 = new DIContainer();
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
        $con = new DIContainer();
        $bind1 = new DIConstantBinding('ship');
        $bind2 = new DIConstantBinding('maker');

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
        $con1 = new DIContainer();
        $con2 = new DIContainer($con1);

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
        $con = new DIContainer();
        $con->setBinding('space', new DIConstantBinding('ship'));
        $con->setBinding('space', new DIConstantBinding('maker'));
    }

    /**
     * @test
     */
    public function shouldWith()
    {
        $con = new DIContainer();
        $con->bind(MockItem::class)->withProvider(new MockItemProvider());

        $creator = $con->with(['foo' => 'bar']);
        $this->assertInstanceOf(IDICreator::class, $creator);

        /** @var MockItem $item */
        $item = $creator->create(MockItem::class);

        $this->assertInstanceOf(MockItem::class, $item);
        $this->assertEquals(['foo' => 'bar'], $item->options);
    }
}
