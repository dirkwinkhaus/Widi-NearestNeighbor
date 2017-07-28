<?php

namespace Widi\NearestNeighbor;

use PHPUnit_Framework_TestCase;
use Widi\NearestNeighbor\Factory\VectorFactory;

/**
 * Class VectorFactoryTest
 * @package Widi\NearestNeighbor
 *
 * @author Dirk Winkhaus <dirkwinkhaus@googlemail.com>
 */
class VectorFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldCreateAVector()
    {
        $testData = [2,2.4];
        $factory = new VectorFactory();
        $vector = $factory->create(...$testData);

        $this->assertInstanceOf(VectorFactoryAwareInterface::class, $vector);
        $this->assertInstanceOf(VectorInterface::class, $vector);
        $this->assertEquals($testData, $vector->getData());
    }
}