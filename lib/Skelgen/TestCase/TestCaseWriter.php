<?php

namespace Skelgen\TestCase;


use Skelgen\ISkelgenConfig;
use Skelgen\Project\IProjectConfig;
use Skelgen\Reflection\ConstructorDependencyGenerator;
use Skelgen\Reflection\CustomReflectionClass;

class TestCaseWriter {
    const CLASS_NAME = __CLASS__;


    function __construct() {
    }


    public function writeTestCase( ISkelgenConfig $skelgenConfig, CustomReflectionClass $customReflectionClass ) {
        $constructorDependencyGenerator = new ConstructorDependencyGenerator();
        $xslTransformTestCodeRenderer   = new \Skelgen\Renderer\XslTransformTestCodeRenderer();

        $projectConfig = $skelgenConfig->createProjectConfig( $customReflectionClass );
        $testConfig    = $this->locateRelevantTestConfig( $projectConfig, $customReflectionClass );
        if ( $testConfig == null ) {
            throw new \UnexpectedValueException( "Cannot locate test config" );
        }

        if ( is_file( $testConfig->getTestOutputFilePath() ) ) {
            throw new \UnexpectedValueException( "Test output path '" . $testConfig->getTestOutputFilePath() . "' already exists" );
        }

        $constructorParameterList = $constructorDependencyGenerator->createConstructorParameterList( $customReflectionClass );
        $testConfig->addConstructorParameters( $constructorParameterList );

        $renderCode = $xslTransformTestCodeRenderer->renderCode( $testConfig );
        $this->generateRequiredSubfolders( $testConfig->getTestOutputFilePath() );
        file_put_contents( $testConfig->getTestOutputFilePath(), $renderCode );
    }


    /**
     * @param IProjectConfig        $projectConfig
     * @param CustomReflectionClass $customReflectionClass
     *
     * @return null|\Skelgen\Test\TestConfig
     */
    private function locateRelevantTestConfig( IProjectConfig $projectConfig,
                                               CustomReflectionClass $customReflectionClass ) {
        $testConfig = null;
        foreach ( $projectConfig->getCustomRuleMatchers() as $testConfigRenderer ) {
            $testConfig = $testConfigRenderer->calculateConfig( $customReflectionClass );
            if ( $testConfig ) {
                return $testConfig;
            }
        }

        return null;
    }


    private function generateRequiredSubfolders( $testFilePath ) {
        $testFilePath = str_replace( '\\', '/', $testFilePath );
        $folderParts  = explode( '/', $testFilePath );
        unset( $folderParts[ count( $folderParts ) - 1 ] );
        $currentDir = '';
        foreach ( $folderParts as $folderPart ) {
            $currentDir .= $folderPart . '/';
            var_dump( $currentDir );
            if ( !is_dir( $currentDir ) ) {
                mkdir( $currentDir );
            }
        }

    }
}
