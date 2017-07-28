<?php

declare(strict_types=1);

namespace Widi\NearestNeighbor;

use Widi\NearestNeighbor\Exception\VectorNotCompatibleException;
use Widi\NearestNeighbor\Factory\VectorFactoryInterface;

/**
 * Class Vector
 * @package Widi\NearestNeighbor
 *
 * @author Dirk Winkhaus <dirkwinkhaus@googlemail.com>
 */
class Vector implements VectorInterface, VectorFactoryAwareInterface
{
    /**
     * @var int[]
     */
    private $data;

    /**
     * @var VectorFactoryInterface
     */
    private $factory;

    /**
     * Vector constructor.
     * @param float[] ...$data
     */
    public function __construct(float ...$data)
    {
        $this->data = $data;
    }

    /**
     * @param VectorFactoryInterface $factory
     * @return VectorInterface
     */
    public function setFactory(VectorFactoryInterface $factory): VectorInterface
    {
        $this->factory = $factory;

        return $this;
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
     * @return float[]
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param VectorInterface $vector
     * @return float
     */
    public function calculateDistanceTo(VectorInterface $vector): float
    {
        return $this->calculateLengthOfConnectingVector(
            $this->createConnectingVector($vector)
        );
    }

    /**
     * @param VectorInterface $vector
     * @return VectorInterface
     * @throws VectorNotCompatibleException
     */
    private function createConnectingVector(VectorInterface $vector): VectorInterface
    {
        if (!$this->isCompatible($vector)) {
            throw new VectorNotCompatibleException();
        }

        $connectingVectorArray = [];
        for ($i = 0; $i < $this->getDimensionCount(); ++$i) {
            $connectingVectorArray[] = $this->getData()[$i] - $vector->getData()[$i];
        }

        if ($this->factory instanceof VectorFactoryInterface) {
            return $this->factory->create(...$connectingVectorArray);
        }

        return new static(...$connectingVectorArray);
    }

    /**
     * @param VectorInterface $vector
     * @return float
     */
    private function calculateLengthOfConnectingVector(VectorInterface $vector): float
    {
        $distanceVector = 0;
        $arrayVector = $vector->getData();

        for ($i = 0; $i < $vector->getDimensionCount(); ++$i) {
            $distanceVector += ($arrayVector[$i]) ** 2;
        }

        return sqrt($distanceVector);
    }
}