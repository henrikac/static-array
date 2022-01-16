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
}