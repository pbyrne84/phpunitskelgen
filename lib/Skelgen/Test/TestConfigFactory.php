<?php
namespace Skelgen\Test;

use Skelgen\File\ExistingFile;

class TestConfigFactory {
    const CLASS_NAME = __CLASS__;


    /**
     * @param ExistingFile     $templateLocation
     * @param string           $testOutputFilePath
     * @param \ReflectionClass $reflectionClass
     *
     * @return TestConfig
     */
    public function createTestConfigFactory( ExistingFile $templateLocation,
                                             $testOutputFilePath,
                                             \ReflectionClass $reflectionClass ) {
        $testConfig = new TestConfig(
            $templateLocation
            , $testOutputFilePath
            , $reflectionClass->getShortName()
            , $reflectionClass->getNamespaceName()
            , $reflectionClass->getShortName() . 'Test'
        );

        return $this->appendPublicReflectedMethods( $testConfig, $reflectionClass );
    }


    /**
     * @param TestConfig       $testConfig
     * @param \ReflectionClass $reflectionClass
     *
     * @return TestConfig
     */
    private function appendPublicReflectedMethods( TestConfig $testConfig, \ReflectionClass $reflectionClass ) {
        $reflectionMethods = $reflectionClass->getMethods( \ReflectionMethod::IS_PUBLIC );
        $testConfig->addReflectionMethods( $reflectionMethods );

        return $testConfig;
    }


}
