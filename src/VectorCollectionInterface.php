<?php

namespace Widi\NearestNeighbor;

use Widi\NearestNeighbor\Exception\VectorAlreadyInCollectionException;
use Widi\NearestNeighbor\Exception\VectorNotInCollectionException;


/**
 * Class VectorCollection
 * @package Widi\NearestNeighbor
 *
 * @author Dirk Winkhaus <dirkwinkhaus@googlemail.com>
 */
interface VectorCollectionInterface
{
    /**
     * @param VectorInterface $vector
     * @return $this
     * @throws VectorAlreadyInCollectionException
     */
    public function addVector(VectorInterface $vector);

    /**
     * @param VectorInterface $vector
     * @return $this
     * @throws VectorNotInCollectionException
     */
    public function removeVector(VectorInterface $vector);

    /**
     * @return int
     */
    public function getCount(): int;

    /**
     * @param VectorInterface $vector
     * @return VectorInterface
     */
    public function findClosest(VectorInterface $vector);
}