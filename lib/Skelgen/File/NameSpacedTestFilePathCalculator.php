<?php
namespace Skelgen\File;

/**
 * Class NameSpacedTestFilePathCalculator
 * This implementation concatenates the baseTestPath,namespaced className and Test.php for the final path
 * @package Skelgen\File
 */
class NameSpacedTestFilePathCalculator implements TestFilePathCalculator {
    const CLASS_NAME = __CLASS__;

    /** @var ExistingDirectory */
    private $testBasePath;


    /**
     * @param ExistingDirectory $testBasePath
     */
    function __construct( ExistingDirectory $testBasePath ) {
        $this->testBasePath = $testBasePath;
    }


    /**
     * @param \ReflectionClass $reflectionClass
     *
     * @return string
     */
    public function calculate( \ReflectionClass $reflectionClass ) {
        return $this->normaliseDirectorySeparators(
            $this->testBasePath->getNormalisedRealPath() . '/' . $reflectionClass->getName() . 'Test.php'
        );
    }


    /**
     * @param $path
     *
     * @return mixed
     */
    private function normaliseDirectorySeparators( $path ) {
        return str_replace( '\\', '/', $path );
    }
}
