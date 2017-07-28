<?php

declare(strict_types=1);

namespace Widi\NearestNeighbor;

use Widi\NearestNeighbor\Exception\VectorAlreadyInCollectionException;
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
        foreach($vectors as $vector) {
            $this->addVector($vector);
        }
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
     * @return VectorCollectionInterface
     * @throws VectorNotInCollectionException
     */
    public function removeVector(VectorInterface $vector): VectorCollectionInterface
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
     * @return null|VectorInterface
     */
    public function findClosest(VectorInterface $selectedVector): ?VectorInterface
    {
        $minDistance = null;
        $closestVector = null;

        foreach ($this->vectors as $vector) {
            $distance = $selectedVector->calculateDistanceTo($vector);

            if ($minDistance === null || $distance < $minDistance) {
                $minDistance = $distance;
                $closestVector = $vector;
            }
        }

        return $closestVector;
    }

}