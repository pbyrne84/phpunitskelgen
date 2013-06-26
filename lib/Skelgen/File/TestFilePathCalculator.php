<?php

namespace Skelgen\File;


/**
 * Class TestFilePathCalculator
 * @package Skelgen\File
 */
interface TestFilePathCalculator {
    const INTERFACE_TestFilePathCalculator = __CLASS__;


    /**
     * @param \ReflectionClass $reflectionClass
     *
     * @return string
     */
    public function calculate( \ReflectionClass $reflectionClass );


}
