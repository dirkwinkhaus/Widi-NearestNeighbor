<?php

declare(strict_types=1);

namespace Widi\NearestNeighbor;

/**
 * Class Vector
 * @package Widi\NearestNeighbor
 *
 * @author Dirk Winkhaus <dirkwinkhaus@googlemail.com>
 */
class Vector implements VectorInterface
{
    /**
     * @var int[]
     */
    private $data;

    /**
     * Vector constructor.
     * @param int[] ...$data
     */
    public function __construct(int ...$data)
    {
        $this->data = $data;
    }

    /**
     * @return int
     */
    public function getDimensionCount(): int
    {
        return count($this->data);
    }

    /**
     * @param VectorInterface $vector
     * @return bool
     */
    public function isCompatible(VectorInterface $vector): bool
    {
        return ($this->getDimensionCount() === $vector->getDimensionCount());
    }

    /**
     * @return int[]
     */
    public function getData(): array
    {
        return $this->data;
    }
}