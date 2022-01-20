<?php declare(strict_types=1);

namespace Henrikac\StaticArray;

use ArrayAccess;

/**
 * Implementation of a static array that can only store items of a single type
 * and has a fixed size.
 *
 * @author Henrik Christensen <sensen1695@hotmail.com>
 */
class StaticArray implements ArrayAccess
{
    /**
     * The type of the items in the array.
     *
     * @var string
     */
    private string $type;

    /**
     * The size of the array.
     *
     * @var integer
     */
    private int $size;

    /**
     * The items in the array.
     *
     * @var array
     */
    private array $items = [];

    /**
     * Initializes a new static array that can only store items of the given type
     * and has a fixed size of the given size.
     * 
     * ```
     * $arr = new StaticArray(int::class, 10);
     * ```
     *
     * @param string $type
     * @param integer $size
     * 
     * @throws \InvalidArgumentException If type is not defined or if size is less than 0.
     */
    public function __construct(string $type, int $size)
    {
        if (!isset($type) || empty($type)) {
            throw new \InvalidArgumentException('Undefined type');
        }

        if ($size < 0) {
            throw new \InvalidArgumentException('Size must be greater than or equal to zero');
        }

        $this->type = $type;
        $this->size = $size;
    }

    /**
     * Returns whether the given offset exists.
     *
     * @param mixed $offset
     * @return boolean
     * 
     * @throws \InvalidArgumentException If offset is not an integer.
     * @throws \OutOfRangeException If offset is less than 0 or greater than or equal to the size of the array.
     */
    public function offsetExists(mixed $offset): bool
    {
        $this->throwIfInvalidOffset($offset);

        return isset($this->items[$offset]);
    }

    /**
     * Returns the item at the given offset if set, otherwise null is returned.
     *
     * @param mixed $offset
     * @return mixed
     * 
     * @throws \InvalidArgumentException If offset is not an integer.
     * @throws \OutOfRangeException If offset is less than 0 or greater than or equal to the size of the array.
     */
    public function offsetGet(mixed $offset): mixed
    {
        $this->throwIfInvalidOffset($offset);

        return isset($this->items[$offset]) ? $this->items[$offset] : null;
    }

    /**
     * Assigns the given value to the specified offset.
     *
     * @param mixed $offset
     * @param mixed $value
     * @return void
     * 
     * @throws \InvalidArgumentException If offset is not an integer or if the given value has an incorrect type.
     * @throws \OutOfRangeException If offset is not null, less than 0 or greater than or equal to the size of the array.
     * @throws \OverflowException If the array is already full.
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->throwIfInvalidOffset($offset);

        if (count($this->items) === $this->size) {
            throw new \OverflowException('Cannot add items to a full array');
        }

        $valueType = gettype($value);

        // This is a very naive hack!
        // TODO: come up with a better solution
        if ($valueType !== $this->type) {
            switch ($valueType) {
                case 'boolean' && $this->type === 'bool':
                    break;
                case 'integer' && $this->type === 'int':
                    break;
                case 'object' && $this->type === $value::class:
                    break;
                default:
                    throw new \InvalidArgumentException(sprintf('Expected item of type %s but got %s', $this->type, gettype($value)));
            }
        }

        $this->items[$offset] = $value;
    }

    /**
     * Unset the given offset.
     *
     * @param mixed $offset
     * @return void
     * 
     * @throws \InvalidArgumentException If offset is not an integer.
     * @throws \OutOfRangeException If offset is less than 0 or greater than or equal to the size of the array.
     */
    public function offsetUnset(mixed $offset): void
    {
        $this->throwIfInvalidOffset($offset);

        unset($this->items[$offset]);
    }

    /**
     * Returns the type of items in the array.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Returns the size of the array.
     *
     * @return integer
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * Checks whether the offset is a valid offset, if not valid an exception is thrown.
     *
     * @param mixed $offset
     * @return void
     * 
     * @throws \InvalidArgumentException If offset is not an integer.
     * @throws \OutOfRangeException If offset is less than 0 or greater than or equal to the size of the array.
     */
    private function throwIfInvalidOffset(mixed $offset): void
    {
        if (!isset($offset) || !is_int($offset)) {
            throw new \InvalidArgumentException(sprintf('Expected offset of type int but got %s', gettype($offset)));
        }

        if ($offset < 0 || $offset >= $this->size) {
            throw new \OutOfRangeException(sprintf('Expected an offset between 0 and %d but got %d', $this->size - 1, $offset));
        }
    }
}