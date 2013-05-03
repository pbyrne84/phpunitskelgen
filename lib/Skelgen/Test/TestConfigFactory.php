<?php
namespace Skelgen\Test;

class TestConfigFactory {
    const CLASS_NAME = __CLASS__;


    public function createTestConfigFactory( \Skelgen\File\ExistingFile $templateLocation, $testOutputFilePath,  \ReflectionClass $reflectionClass ) {
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
     * @param \Skelgen\Test\TestConfig $testConfig
     * @param \ReflectionClass         $reflectionClass
     * @return \Skelgen\Test\TestConfig
     */
    private function appendPublicReflectedMethods( TestConfig $testConfig, \ReflectionClass $reflectionClass ) {
        $reflectionMethods = $reflectionClass->getMethods( \ReflectionMethod::IS_PUBLIC );
        $testConfig->addReflectionMethods( $reflectionMethods );
        return $testConfig;
    }


}
