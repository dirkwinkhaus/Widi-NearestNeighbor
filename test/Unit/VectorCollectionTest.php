<?php

namespace Widi\NearestNeighbor;

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
     * @dataProvider getVectorsToAddAndRemove
     *
     * @param VectorInterface $vector
     */
    public function itShouldAddAndRemove(VectorInterface $vector)
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
    public function getVectorsToAddAndRemove()
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
    public function itShouldCount(bool $equal, int $count, VectorInterface ...$vectors)
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
     * @return object
     */
    private function createVectorInterfaceMock(): VectorInterface
    {
        return $this->prophesize(VectorInterface::class)->reveal();
    }
}