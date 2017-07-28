<?php


namespace Widi\NearestNeighbor\Factory;

use Widi\NearestNeighbor\Vector;
use Widi\NearestNeighbor\VectorFactoryAwareInterface;

/**
 * Class VectorFactory
 * @package Widi\NearestNeighbor\Factory
 *
 * @author Dirk Winkhaus <dirkwinkhaus@googlemail.com>
 */
class VectorFactory implements VectorFactoryInterface
{

    /**
     * @param float[] ...$data
     * @return Vector
     */
    public function create(float ...$data)
    {
        $vector = new Vector(...$data);

        if ($vector instanceof VectorFactoryAwareInterface) {
            $vector->setFactory($this);
        }

        return $vector;
    }
}