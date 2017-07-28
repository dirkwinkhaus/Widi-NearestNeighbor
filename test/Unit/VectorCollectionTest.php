<?php

namespace Widi\NearestNeighbor;
use Widi\NearestNeighbor\Exception\VectorAlreadyInCollectionException;
use Widi\NearestNeighbor\Exception\VectorNotInCollectionException;

/**
 * Class VectorCollectionTest
 * @package Widi\NearestNeighbor
 *
 * @author Dirk Winkhaus <dirkwinkhaus@googlemail.com>
 */
class VectorCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider getVectorsForConstructor
     *
     * @param array $vectors
     * @param int $expectedCount
     */
    public function itShouldAddVectorsAtConstruct(array $vectors, int $expectedCount): void
    {
        $collection = new VectorCollection(...$vectors);

        $this->assertEquals($expectedCount, $collection->getCount());
    }

    /**
     * @return array
     */
    public function getVectorsForConstructor(): array
    {
        return [
            [[new Vector()], 1],
            [[new Vector(), new Vector()], 2],
            [[new Vector(), new Vector(), new Vector()], 3],
            [[new Vector(), new Vector(), new Vector(), new Vector()], 4],
        ];
    }

    /**
     * @test
     * @dataProvider getVectorsToAddAndRemove
     *
     * @param VectorInterface $vector
     */
    public function itShouldAddAndRemove(VectorInterface $vector): void
    {
        $vectorCollection = new VectorCollection();

        $vectorCollection->addVector($vector);
        $this->assertEquals(1, $vectorCollection->getCount());

        $vectorCollection->removeVector($vector);
        $this->assertEquals(0, $vectorCollection->getCount());
    }

    /**
     * @return array
     */
    public function getVectorsToAddAndRemove(): array
    {
        return [
            [$this->createVectorInterfaceMock()],
            [$this->createVectorInterfaceMock()],
            [$this->createVectorInterfaceMock()],
            [$this->createVectorInterfaceMock()],
            [$this->createVectorInterfaceMock()],
        ];
    }

    /**
     * @test
     * @dataProvider getVectorCollectionCount
     *
     * @param bool $equal
     * @param int $count
     * @param VectorInterface[] ...$vectors
     */
    public function itShouldCount(bool $equal, int $count, VectorInterface ...$vectors): void
    {
        $vectorCollection = new VectorCollection(...$vectors);

        if ($equal) {
            $this->assertEquals($count, $vectorCollection->getCount());
        } else {
            $this->assertNotEquals($count, $vectorCollection->getCount());
        }
    }

    /**
     * @return array
     */
    public function getVectorCollectionCount(): array
    {
       return [
           [true, 0],
           [true, 1, $this->createVectorInterfaceMock()],
           [true, 2, $this->createVectorInterfaceMock(), $this->createVectorInterfaceMock()],
           [true, 3, $this->createVectorInterfaceMock(), $this->createVectorInterfaceMock(), $this->createVectorInterfaceMock()],
           [false, 1],
           [false, 2, $this->createVectorInterfaceMock()],
           [false, 3, $this->createVectorInterfaceMock(), $this->createVectorInterfaceMock()],
           [false, 4, $this->createVectorInterfaceMock(), $this->createVectorInterfaceMock(), $this->createVectorInterfaceMock()],
       ];
    }

    /**
     * @test
     */
    public function itShouldThrowExceptionOnConstructCausedByAddingSameInstanceTwice(): void
    {
        $vector = $this->createVectorInterfaceMock();
        $this->expectException(VectorAlreadyInCollectionException::class);

        $collection = new VectorCollection($vector, $vector);
    }

    /**
     * @test
     */
    public function itShouldThrowExceptionOnAddVectorCausedByAddingSameInstanceTwice(): void
    {
        $vector = $this->createVectorInterfaceMock();
        $this->expectException(VectorAlreadyInCollectionException::class);

        $collection = new VectorCollection();
        $collection->addVector($vector);
        $collection->addVector($vector);
    }

    /**
     * @test
     */
    public function itShouldThrowExceptionOnRemovingVectorCausedByRemovingNotExistingInstance(): void
    {
        $vector = $this->createVectorInterfaceMock();
        $this->expectException(VectorNotInCollectionException::class);

        $collection = new VectorCollection();
        $collection->removeVector($vector);
    }

    /**
     * @return object
     */
    private function createVectorInterfaceMock(): VectorInterface
    {
        return $this->prophesize(VectorInterface::class)->reveal();
    }
}