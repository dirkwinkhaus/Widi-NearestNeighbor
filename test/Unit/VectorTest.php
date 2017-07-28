<?php

namespace Widi\NearestNeighbor;

use PHPUnit_Framework_TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\MethodProphecy;
use Widi\NearestNeighbor\Exception\VectorNotCompatibleException;
use Widi\NearestNeighbor\Factory\VectorFactoryInterface;

/**
 * Class VectorTest
 * @package Widi\NearestNeighbor
 *
 * @author Dirk Winkhaus <dirkwinkhaus@googlemail.com>
 */
class VectorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider getVectorDimensions
     *
     * @param $expectedCount
     * @param array ...$dimensions
     */
    public function itShouldGetDimensions($expectedCount, ...$dimensions): void
    {
        $vector = new Vector(...$dimensions);

        $this->assertEquals($expectedCount, $vector->getDimensionCount());
        $this->assertEquals($dimensions, $vector->getData());
    }

    /**
     * @return array
     */
    public function getVectorDimensions(): array
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
    public function itShouldBeCompatible(array $vectorDataA, array $vectorDataB, bool $shouldBeCompatible): void
    {
        $vectorA = new Vector(...$vectorDataA);
        $vectorB = new Vector(...$vectorDataB);

        $this->assertEquals($vectorA->isCompatible($vectorB), $shouldBeCompatible);
    }

    /**
     * @return array
     */
    public function getVectorCompatibles(): array
    {
        return [
            [[], [], true],
            [[1], [], false],
            [[1], [1], true],
            [[1], [1, 2], false],
            [[1, 2], [1, 2], true],
        ];
    }

    /**
     * @test
     * @dataProvider getVectorDistanceData
     *
     * @param array $vectorAData
     * @param array $vectorBData
     * @param float $expectedDistance
     */
    public function itShouldCalculateTheDistance(array $vectorAData, array $vectorBData, float $expectedDistance): void
    {
        $vectorA = new Vector(...$vectorAData);
        $vectorB = new Vector(...$vectorBData);
        $calculatedDistance = round($vectorA->calculateDistanceTo($vectorB), 2);

        $this->assertEquals($calculatedDistance, $expectedDistance);
    }

    /**
     * @return array
     */
    public function getVectorDistanceData(): array
    {
        return [
            [[7, 4, 3], [17, 6, 2], 10.25],
            [[31, 10, 90], [-2, -4, -19], 114.74],
            [[-7, -4], [17, 6.5], 26.20]
        ];
    }

    /**
     * @test
     */
    public function itShouldUseTheFactory(): void
    {
        $factoryMock = $this->prophesize(VectorFactoryInterface::class);
        /** @var MethodProphecy $method */
        $method = $factoryMock->create(Argument::any(), Argument::any())->willReturn(new Vector(5, 5));
        $method->shouldBeCalledTimes(1);

        $vectorA = new Vector(1,1);
        $vectorA->setFactory($factoryMock->reveal());
        $vectorB = new Vector(2,2);

        $distance = $vectorA->calculateDistanceTo($vectorB);

        $this->assertEquals(7.0710678118655, $distance);
    }

    /**
     * @test
     */
    public function itShouldThrowExceptionCausedByNonCompatibleVectors(): void
    {
        $vectorA = new Vector(1, 2);
        $vectorB = new Vector(1, 2, 3);

        $this->expectException(VectorNotCompatibleException::class);
        $vectorA->calculateDistanceTo($vectorB);
    }
}