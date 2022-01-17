<?php declare(strict_types=1);

namespace Henrikac\StaticArray;

/**
 * Implementation of a static array that can only store items of a single type
 * and has a fixed size
 *
 * @author Henrik Christensen <sensen1695@hotmail.com>
 */
class StaticArray
{
    /**
     * The type of the items in the array
     *
     * @var string
     */
    private string $type;

    /**
     * The size of the array
     *
     * @var integer
     */
    private int $size;

    /**
     * The items in the array
     *
     * @var array
     */
    private array $items = [];

    /**
     * Initializes a new static array that can only store items of the given type
     * and has a fixed size of the given size
     *
     * @param string $type
     * @param integer $size
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
     * Returns the type of items in the array
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Returns the size of the array
     *
     * @return integer
     */
    public function getSize(): int
    {
        return $this->size;
    }
}