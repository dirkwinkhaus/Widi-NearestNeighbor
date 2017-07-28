<?php

namespace Widi\NearestNeighbor\Factory;

use Widi\NearestNeighbor\VectorInterface;

/**
 * Interface VectorFactoryInterface
 * @package Widi\NearestNeighbor\Factory
 *
 * @author Dirk Winkhaus <dirkwinkhaus@googlemail.com>
 */
interface VectorFactoryInterface
{
    /**
     * @param float[] ...$data
     * @return VectorInterface
     */
    public function create(float ...$data): VectorInterface;
}