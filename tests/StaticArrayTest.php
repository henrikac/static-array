<?php declare(strict_types=1);

use Henrikac\StaticArray\StaticArray;
use PHPUnit\Framework\TestCase;

class StaticArrayTest extends TestCase
{
    public function testCanInstantiateStaticArray(): void
    {
        $arr = new StaticArray(int::class, 5);

        $this->assertNotNull($arr);
        $this->assertInstanceOf(StaticArray::class, $arr);
    }

    public function testGetTypeReturnsCorrectType(): void
    {
        $arr = new StaticArray(int::class, 5);

        $expected = 'int';
        $actual = $arr->getType();

        $this->assertEquals(
            $expected,
            $actual
        );
    }

    public function testInvalidArgumentExceptionIsThrownIfTypeIsEmpty(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new StaticArray('', 3);
    }

    public function testGetSizeReturnsCorrectSize(): void
    {
        $expected = 10;
        $arr = new StaticArray(int::class, $expected);

        $actual = $arr->getSize();

        $this->assertEquals(
            $expected,
            $actual
        );
    }
    
    public function testInvalidArgumentExceptionIsThrownIfSizeIsLessThanZero(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new StaticArray(string::class, -1);
    }
}