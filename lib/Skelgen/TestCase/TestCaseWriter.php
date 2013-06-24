<?php

namespace Skelgen\TestCase;


use Skelgen\File\AddToVersionControlAction;
use Skelgen\File\ExistingFile;
use Skelgen\File\SubFolderGenerator;
use Skelgen\IDE\IdeFileOpener;
use Skelgen\Project\ProjectConfig;
use Skelgen\Reflection\ConstructorDependencyGenerator;
use Skelgen\Reflection\CustomReflectionClass;
use Skelgen\Renderer\TestCoderRenderer;

class TestCaseWriter {
    const CLASS_NAME = __CLASS__;

    /** @var \Skelgen\IDE\IdeFileOpener */
    private $ideFileOpener;

    /** @var \Skelgen\File\SubFolderGenerator */
    private $subFolderGenerator;

    /** @var \Skelgen\Renderer\TestCoderRenderer */
    private $testCoderRenderer;

    /** @var \Skelgen\File\AddToVersionControlAction */
    private $addToVersionControlAction;


    /**
     * @param IdeFileOpener             $ideFileOpener
     * @param TestCoderRenderer         $testCoderRenderer
     * @param SubFolderGenerator        $subFolderGenerator
     * @param AddToVersionControlAction $addToVersionControlAction
     */
    function __construct( IdeFileOpener $ideFileOpener,
                          TestCoderRenderer $testCoderRenderer,
                          SubFolderGenerator $subFolderGenerator,
                          AddToVersionControlAction $addToVersionControlAction ) {
        $this->ideFileOpener             = $ideFileOpener;
        $this->testCoderRenderer         = $testCoderRenderer;
        $this->subFolderGenerator        = $subFolderGenerator;
        $this->addToVersionControlAction = $addToVersionControlAction;
    }


    /**
     * Writes the test case using the project config and the reflection class for the class to test.
     *
     * @param ProjectConfig         $projectConfig
     * @param CustomReflectionClass $customReflectionClass
     *
     * @throws \UnexpectedValueException
     */
    public function writeTestCase( ProjectConfig $projectConfig, CustomReflectionClass $customReflectionClass ) {
        $constructorDependencyGenerator = new ConstructorDependencyGenerator();
        $testConfig                     = $this->locateRelevantTestConfig( $projectConfig, $customReflectionClass );
        if ( $testConfig == null ) {
            throw new \UnexpectedValueException( "Cannot locate test config" );
        }

        if ( is_file( $testConfig->getTestOutputFilePath() ) ) {
            throw new \UnexpectedValueException( "Test output path '" . $testConfig->getTestOutputFilePath() . "' already exists" );
        }

        $constructorParameterList = $constructorDependencyGenerator->createConstructorParameterList( $customReflectionClass );
        $testConfig->addConstructorParameters( $constructorParameterList );

        $renderedCode = $this->testCoderRenderer->renderCode( $testConfig );

        $this->subFolderGenerator->generateRequiredSubFolders( $testConfig->getTestOutputFilePath() );
        file_put_contents( $testConfig->getTestOutputFilePath(), $renderedCode );

        $this->addToVersionControlAction->addFileToVersionControl( new ExistingFile( $testConfig->getTestOutputFilePath() ) );
        $this->ideFileOpener->openFile( new \SplFileInfo( $testConfig->getTestOutputFilePath() ) );
    }


    /**
     * Looks through all the matches for a project to see which one suits the class to be tested. For example a controller
     * class may benefit from a different setup than a plain vanilla test.
     *
     * @param ProjectConfig         $projectConfig
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
