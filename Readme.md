# Widi-NearestNeighbor Feature Set
## Sample of usage

    use Widi\NearestNeighbor\Vector;
    use Widi\NearestNeighbor\Factory\VectorFactory;
    
    $vectorATwoDimensions = new Vector(11,2);
    $vectorBTwoDimensions = new Vector(4,5);
    $vectorAThreeDimensions = new Vector(1,5,10);
    
    // this will return true
    $vectorATwoDimensions->isCompatible($vectorBTwoDimensions);
    // this will return false
    $vectorATwoDimensions->isCompatible($vectorThreeDimensions);
    
    // returns 2
    $vectorATwoDimensions->getDimensionCount();
    // returns 3
    $vectorAThreeDimensions->getDimensionCount();
    
    // this should return 7.615773
    $vectorATwoDimensions->calculateDistanceTo($vectorBTwoDimensions);
    
    // with factory
    $factory = new VectorFactory();
    $vector = $factory->create(1,2,3);