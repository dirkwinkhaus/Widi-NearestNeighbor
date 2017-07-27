<?php

namespace Widi\NearestNeighbor;

/**
 * Class FindClosestTest
 * @package Widi\NearestNeighbor
 *
 * @author Dirk Winkhaus <dirkwinkhaus@googlemail.com>
 */
class FindClosestTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     * @dataProvider getVectors
     *
     * @param VectorInterface $vector
     * @param int $indexOfClosestVector
     * @param VectorInterface[] ...$vectors
     */
    public function itShouldProvideTheClosestVector(VectorInterface $vector, int $indexOfClosestVector, VectorInterface ...$vectors)
    {
        $vectorCollection = new VectorCollection(...$vectors);
        $foundVector = $vectorCollection->findClosest($vector);

        $this->assertSame($vectors[$indexOfClosestVector], $foundVector);
    }

    /**
     * @return array
     */
    public function getVectors(): array
    {
        return [
            [new Vector(0, 0), 0, new Vector(100,100)],
            [new Vector(0, 0), 0, new Vector(100,100), new Vector(200,100)],
            [new Vector(0, 0), 1, new Vector(100,100), new Vector(10,100)],
            [new Vector(0, 0), 2, new Vector(100,100), new Vector(400,100), new Vector(-99,-99)],
        ];
    }
}