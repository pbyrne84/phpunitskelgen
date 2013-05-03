<?php
namespace Skelgen\Test;

interface TestConfigRenderer {

    /**
     * @param \Skelgen\Reflection\CustomReflectionClass $reflectionClass
     * @return TestConfig|null
     */
    public function calculateConfig( \Skelgen\Reflection\CustomReflectionClass $reflectionClass );
}
