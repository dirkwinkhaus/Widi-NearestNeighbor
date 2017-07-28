<?php

namespace Widi\NearestNeighbor;

use Widi\NearestNeighbor\Factory\VectorFactoryInterface;

/**
 * Interface FactoryAwareInterface
 * @package Widi\NearestNeighbor
 *
 * @author Dirk Winkhaus <dirkwinkhaus@googlemail.com>
 */
interface VectorFactoryAwareInterface
{
    /**
     * @param VectorFactoryInterface $factory
     * @return VectorInterface
     */
    public function setFactory(VectorFactoryInterface $factory): VectorInterface;
}