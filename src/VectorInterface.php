<?php

namespace Widi\NearestNeighbor;


/**
 * Class Vector
 * @package Widi\NearestNeighbor
 *
 * @author Dirk Winkhaus <dirkwinkhaus@googlemail.com>
 */
interface VectorInterface
{
    /**
     * @return int
     */
    public function getDimensionCount(): int;

    /**
     * @param VectorInterface $vector
     * @return bool
     */
    public function isCompatible(VectorInterface $vector): bool;

    /**
     * @return int[]
     */
    public function getData(): array;
}