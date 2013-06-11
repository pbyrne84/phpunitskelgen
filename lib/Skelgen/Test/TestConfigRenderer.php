<?php
namespace Skelgen\Test;

use Skelgen\Reflection\CustomReflectionClass;

interface TestConfigRenderer {

    /**
     * @param CustomReflectionClass $reflectionClass
     * @return TestConfig|null
     */
    public function calculateConfig( CustomReflectionClass $reflectionClass );
}
