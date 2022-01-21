<?php declare(strict_types=1);

use Henrikac\StaticArray\StaticArray;
use PHPUnit\Framework\TestCase;

class TestClass {}

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

    public function testCountReturnsCorrectResult(): void
    {
        $arr = new StaticArray(string::class, 10);

        $arr[0] = 'Alice';
        $arr[1] = 'Bob';
        $arr[2] = 'Eve';

        unset($arr[0]);

        $this->assertCount(2, $arr);
    }

    public function testArrayIsIterable(): void
    {
        $items = [1, 2, 3, 4, 5];
        $arr = new StaticArray(int::class, count($items));

        for ($i = 0; $i < count($items); $i++) {
            $arr[$i] = $items[$i];
        }

        $counter = 0;

        foreach ($arr as $a) {
            $this->assertEquals($items[$counter++], $a);
        }

        $this->assertEquals(count($items), $counter);
    }

    public function testOffsetSetCanSetValueCorrectly(): void
    {
        $arr = new StaticArray(string::class, 3);

        $arr[0] = 'Alice';
        $arr[1] = 'Bob';
        $arr[2] = 'Eve';

        $this->assertEquals('Eve', $arr[2]);
    }

    public function testOffsetSetCanHandleClassesToo(): void
    {
        $arr = new StaticArray(TestClass::class, 2);

        $arr[0] = new TestClass();
        $arr[1] = new TestClass();

        $this->assertInstanceOf(TestClass::class, $arr[0]);
    }

    public function testOffsetExistsReturnsTrueIfOffsetIsSet(): void
    {
        $arr = new StaticArray(int::class, 4);

        $arr[0] = (int)4;
        $arr[1] = (int)7;
        $arr[2] = (int)2;

        $this->assertTrue(isset($arr[1]));
    }

    public function testOffsetExistsReturnsFalseIfOffsetIsNotSet(): void
    {
        $arr = new StaticArray(int::class, 4);

        $arr[0] = (int)4;
        $arr[1] = (int)7;
        $arr[2] = (int)2;

        $this->assertFalse(isset($arr[3]));
    }

    public function testOffsetExistsThrowsInvalidArgumentExceptionIfOffsetIsNotAnInt(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $arr = new StaticArray(int::class, 4);

        isset($arr['bob']);
    }

    public function testOffsetExistsThrowsOutOfRangeExceptionIfOffsetIsOutOfRange(): void
    {
        $this->expectException(\OutOfRangeException::class);

        $arr = new StaticArray(int::class, 4);

        isset($arr[4]);
    }

    public function testOffsetGetReturnsCorrectValue(): void
    {
        $arr = new StaticArray(int::class, 4);

        $arr[0] = (int)4;
        $arr[1] = (int)7;
        $arr[2] = (int)2;

        $this->assertEquals(7, $arr[1]);
    }

    public function testOffsetGetThrowsInvalidArgumentExceptionIfOffsetIsNotAnInt(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $arr = new StaticArray(int::class, 4);

        $arr[0] = (int)4;
        $arr[1] = (int)7;
        $arr[2] = (int)2;

        $arr['bob'];
    }

    public function testOffsetGetThrowsOutOfRangeExceptionIfOffsetIsOutOfRange(): void
    {
        $this->expectException(\OutOfRangeException::class);

        $arr = new StaticArray(int::class, 4);

        $arr[4];
    }

    public function testOffsetUnsetUnsetsOffset(): void
    {
        $arr = new StaticArray(int::class, 4);

        $arr[0] = (int)4;
        $arr[1] = (int)7;
        $arr[2] = (int)2;

        unset($arr[1]);

        $this->assertNull($arr[1]);
    }

    public function testOffsetUnsetThrowsInvalidArgumentExceptionIfOffsetIsNotAnInt(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $arr = new StaticArray(int::class, 4);

        $arr[] = (int)4;
        $arr[] = (int)7;
        $arr[] = (int)2;

        unset($arr['bob']);
    }

    public function testOffsetUnsetThrowsOutOfRangeExceptionIfOffsetIsOutOfRange(): void
    {
        $this->expectException(\OutOfRangeException::class);

        $arr = new StaticArray(int::class, 4);

        unset($arr[4]);
    }
}