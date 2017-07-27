<?php

namespace Widi\NearestNeighbor;

/**
 * Class VectorTest
 * @package Widi\NearestNeighbor
 *
 * @author Dirk Winkhaus <dirkwinkhaus@googlemail.com>
 */
class VectorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider getVectorDimensions
     *
     * @param $expectedCount
     * @param array ...$dimensions
     */
    public function itShouldGetDimensions($expectedCount, ...$dimensions)
    {
        $vector = new Vector(...$dimensions);

        $this->assertEquals($expectedCount, $vector->getDimensionCount());
        $this->assertEquals($dimensions, $vector->getData());
    }

    /**
     * @return array
     */
    public function getVectorDimensions()
    {
        return [
            [0],
            [1, 2],
            [2, 3, 4],
            [3, 4, 5, 6],
        ];
    }

    /**
     * @test
     * @dataProvider getVectorCompatibles
     *
     * @param array $vectorDataA
     * @param array $vectorDataB
     * @param bool $shouldBeCompatible
     */
    public function itShouldBeCompatible(array $vectorDataA, array $vectorDataB, bool $shouldBeCompatible)
    {
        $vectorA = new Vector(...$vectorDataA);
        $vectorB = new Vector(...$vectorDataB);

        $this->assertEquals($vectorA->isCompatible($vectorB), $shouldBeCompatible);
    }

    /**
     * @return array
     */
    public function getVectorCompatibles()
    {
        return [
          [[], [], true],
          [[1], [], false],
          [[1], [1], true],
          [[1], [1, 2], false],
          [[1, 2], [1, 2], true],
        ];
    }
}