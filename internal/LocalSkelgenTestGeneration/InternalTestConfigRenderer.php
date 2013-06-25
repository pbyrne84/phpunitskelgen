<?php

namespace LocalSkelgenTestGeneration;


use Skelgen\File\ExistingFile;
use Skelgen\Project\ProjectConfig;
use Skelgen\Reflection\CustomReflectionClass;
use Skelgen\Test\TestConfig;
use Skelgen\Test\TestConfigRenderer;

class InternalTestConfigRenderer implements TestConfigRenderer {
    const CLASS_NAME = __CLASS__;

    /** @var ProjectConfig */
    private $projectConfig;


    function __construct( ProjectConfig $projectConfig ) {
        $this->projectConfig = $projectConfig;
    }

   /**
     * @param CustomReflectionClass $reflectionClass
     *
     * @return TestConfig|null
     */
    public function calculateConfig( CustomReflectionClass $reflectionClass ) {
        $testConfig = TestConfig::createFromReflectionClass(
            new ExistingFile( __DIR__ . '/template/StandardTestTemplate.xsl' ),
            $this->projectConfig->getTestOutputFilePath(),
            $reflectionClass
        );

        $this->appendPublicReflectedMethods( $testConfig, $reflectionClass );
        return $testConfig;
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
