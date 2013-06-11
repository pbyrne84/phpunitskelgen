<?php

namespace Skelgen\TestCase;


use Skelgen\File\SubFolderGenerator;
use Skelgen\IDE\IdeFileOpener;
use Skelgen\Project\ProjectConfig;
use Skelgen\Reflection\ConstructorDependencyGenerator;
use Skelgen\Reflection\CustomReflectionClass;
use Skelgen\Renderer\TestCoderRenderer;

class TestCaseWriter {
    const CLASS_NAME = __CLASS__;

    /** @var \Skelgen\IDE\IdeFileOpener  */
    private $phpStormFileOpener;

    /** @var \Skelgen\File\SubFolderGenerator */
    private $subFolderGenerator;

    /** @var \Skelgen\Renderer\TestCoderRenderer */
    private $testCoderRenderer;


    function __construct( IdeFileOpener $phpStormFileOpener,
                          TestCoderRenderer $testCoderRenderer,
                          SubFolderGenerator $subFolderGenerator) {
        $this->phpStormFileOpener = $phpStormFileOpener;
        $this->testCoderRenderer = $testCoderRenderer;
        $this->subFolderGenerator = $subFolderGenerator;
    }


    public function writeTestCase( ProjectConfig $projectConfig, CustomReflectionClass $customReflectionClass ) {
        $constructorDependencyGenerator = new ConstructorDependencyGenerator();
        $testConfig    = $this->locateRelevantTestConfig( $projectConfig, $customReflectionClass );
        if ( $testConfig == null ) {
            throw new \UnexpectedValueException( "Cannot locate test config" );
        }

        if ( is_file( $testConfig->getTestOutputFilePath() ) ) {
            throw new \UnexpectedValueException( "Test output path '" . $testConfig->getTestOutputFilePath() . "' already exists" );
        }

        $constructorParameterList = $constructorDependencyGenerator->createConstructorParameterList( $customReflectionClass );
        $testConfig->addConstructorParameters( $constructorParameterList );

        $renderedCode = $this->testCoderRenderer->renderCode( $testConfig );

        $this->subFolderGenerator->generateRequiredSubfolders( $testConfig->getTestOutputFilePath() );
        file_put_contents( $testConfig->getTestOutputFilePath(), $renderedCode );

        $this->phpStormFileOpener->openFile( new \SplFileInfo( $testConfig->getTestOutputFilePath() ) );
    }


    /**
     * @param ProjectConfig        $projectConfig
     * @param CustomReflectionClass $customReflectionClass
     *
     * @return null|\Skelgen\Test\TestConfig
     */
    private function locateRelevantTestConfig( ProjectConfig $projectConfig,
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
}
