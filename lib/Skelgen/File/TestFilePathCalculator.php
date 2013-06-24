<?php
namespace Skelgen\File;
use JESkelgen\Calculator\OutputDetailsFactoryParameters;

class TestFilePathCalculator {
    const CLASS_NAME = __CLASS__;

    /** @var \JESkelgen\Calculator\OutputDetailsFactoryParameters */
    private $outputDetailsFactoryParameters;

    /**
     * @param OutputDetailsFactoryParameters $outputDetailsFactoryParameters
     */
    function __construct( OutputDetailsFactoryParameters $outputDetailsFactoryParameters  ) {
        $this->outputDetailsFactoryParameters = $outputDetailsFactoryParameters;
    }


    /**
     * @param \ReflectionClass $reflectionClass
     *
     * @return mixed|string
     */
    public function calculate( \ReflectionClass $reflectionClass ) {
        return $this->normaliseDirectorySeperators(
            $this->outputDetailsFactoryParameters->getDefaultBaseTestPath() . '/' . $reflectionClass->getName() . 'Test.php'
        );
    }


    /**
     * @param $path
     *
     * @return mixed
     */
    private function normaliseDirectorySeperators( $path ) {
        return str_replace( '\\', '/', $path );
    }
}
