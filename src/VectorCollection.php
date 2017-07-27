<?php

declare(strict_types=1);

namespace Widi\NearestNeighbor;

use Widi\NearestNeighbor\Exception\VectorAlreadyInCollectionException;
use Widi\NearestNeighbor\Exception\VectorNotCompatibleException;
use Widi\NearestNeighbor\Exception\VectorNotInCollectionException;

/**
 * Class VectorCollection
 * @package Widi\NearestNeighbor
 *
 * @author Dirk Winkhaus <dirkwinkhaus@googlemail.com>
 */
class VectorCollection implements VectorCollectionInterface
{
    /**
     * @var VectorInterface[]
     */
    private $vectors = [];

    /**
     * VectorCollection constructor.
     * @param VectorInterface[] $vectors
     */
    public function __construct(VectorInterface ...$vectors)
    {
        $this->vectors = $vectors;
    }

    /**
     * @param VectorInterface $vector
     * @return $this
     * @throws VectorAlreadyInCollectionException
     */
    public function addVector(VectorInterface $vector)
    {
        if (isset($this->vectors[spl_object_hash($vector)])) {
            throw new VectorAlreadyInCollectionException();
        }

        $this->vectors[spl_object_hash($vector)] = $vector;

        return $this;
    }

    /**
     * @param VectorInterface $vector
     * @return $this
     * @throws VectorNotInCollectionException
     */
    public function removeVector(VectorInterface $vector)
    {
        if (!isset($this->vectors[spl_object_hash($vector)])) {
            throw new VectorNotInCollectionException();
        }

        unset($this->vectors[spl_object_hash($vector)]);

        return $this;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return count($this->vectors);
    }

    /**
     * @param VectorInterface $selectedVector
     * @return VectorInterface
     */
    public function findClosest(VectorInterface $selectedVector)
    {
        $minDistance = null;
        $closestVector = null;

        foreach ($this->vectors as $vector) {
            $connectingVectorArray = $this->createConnectingArrayVector($selectedVector, $vector);
            $distance = $this->getConnectingArrayVectorLength($connectingVectorArray);

            if ($minDistance === null || $distance < $minDistance) {
                $minDistance = $distance;
                $closestVector = $vector;
            }
        }
        return $closestVector;
    }

    /**
     * @param VectorInterface $vectorA
     * @param VectorInterface $vectorB
     * @return array
     * @throws VectorNotCompatibleException
     */
    private function createConnectingArrayVector(VectorInterface $vectorA, VectorInterface $vectorB): array
    {
        if (!$vectorA->isCompatible($vectorB)) {
            throw new VectorNotCompatibleException();
        }

        $connectingVectorArray = [];
        for ($i = 0; $i < $vectorA->getDimensionCount(); ++$i) {
            $connectingVectorArray[] = $vectorA->getData()[$i] - $vectorB->getData()[$i];
        }

        return $connectingVectorArray;
    }

    /**
     * @param array $arrayVector
     * @return float
     */
    private function getConnectingArrayVectorLength(array $arrayVector): float
    {
        $distanceVector = 0;

        for ($i = 0; $i < count($arrayVector); ++$i) {
            $distanceVector += ($arrayVector[$i]) ** 2;
        }

        return sqrt($distanceVector);
    }
}