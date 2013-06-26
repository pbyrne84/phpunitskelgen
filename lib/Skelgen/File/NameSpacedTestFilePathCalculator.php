<?php
namespace Skelgen\File;
use JESkelgen\Calculator\OutputDetailsFactoryParameters;

/**
 * Class NameSpacedTestFilePathCalculator
 * This implementation concatenates the baseTestPath,namespaced className and Test.php for the final path
 * @package Skelgen\File
 */
class NameSpacedTestFilePathCalculator implements TestFilePathCalculator {
    const CLASS_NAME = __CLASS__;

    /** @var \JESkelgen\Calculator\OutputDetailsFactoryParameters */
    private $outputDetailsFactoryParameters;


    /**
     * @param OutputDetailsFactoryParameters $outputDetailsFactoryParameters
     */
    function __construct( OutputDetailsFactoryParameters $outputDetailsFactoryParameters ) {
        $this->outputDetailsFactoryParameters = $outputDetailsFactoryParameters;
    }


    /**
     * @param \ReflectionClass $reflectionClass
     *
     * @return string
     */
    public function calculate( \ReflectionClass $reflectionClass ) {
        return $this->normaliseDirectorySeparators(
            $this->outputDetailsFactoryParameters->getBaseTestPath()
            . '/' . $reflectionClass->getName() . 'Test.php'
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
