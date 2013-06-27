<?php

namespace LocalSkelgenTestGeneration;

use Skelgen\File\NameSpacedTestFilePathCalculator;
use Skelgen\Project\GenericProjectConfig;
use Skelgen\Config\SkelgenConfig;
use Skelgen\File\ExistingDirectory;
use Skelgen\File\ExistingFile;
use Skelgen\File\VerifiedFileSystemResource;
use Skelgen\File;

class InternalSkelgenConfig implements SkelgenConfig {
    const CLASS_NAME = __CLASS__;

    const PROJECT_REGEX = '~(.*/phpunitskelgen/)~i';


    /**
     * @inheritdoc
     */
    public function isProject( VerifiedFileSystemResource $verifiedFileSystemResource ) {
        return preg_match( self::PROJECT_REGEX, $verifiedFileSystemResource->getNormalisedRealPath() );
    }


    /**
     * @inheritdoc
     */
    public function createProjectConfig( \ReflectionClass $classToTest ) {
        $projectConfig = new GenericProjectConfig(
            $this->getProjectName(),
            $this->getTestOutputFilePath( $classToTest ),
            $this->getBaseFolder( new ExistingFile( $classToTest->getFileName() ) ),
            self::PROJECT_REGEX
        );

        $projectConfig->setTestConfigRenderers( $this->getTestConfigRenderers( $projectConfig ) );

        return $projectConfig;
    }


    /**
     * @inheritdoc
     */
    public function getProjectName() {
        return 'Skelgen';
    }


    /**
     * @param \ReflectionClass $classToTest
     *
     * @return string
     */
    private function getTestOutputFilePath( \ReflectionClass $classToTest ) {
        $baseProjectFolder = $this
                ->getBaseFolder( new ExistingFile( $classToTest->getFileName() ) )
                ->getRealPath();

        $baseTestPath           = new ExistingDirectory( $baseProjectFolder . '/test/' );
        $testFilePathCalculator = new NameSpacedTestFilePathCalculator( $baseTestPath );

        return $testFilePathCalculator->calculate( $classToTest );
    }


    /**
     * @param VerifiedFileSystemResource $testFileLocation
     *
     * @return \Skelgen\File\ExistingDirectory
     */
    private function getBaseFolder( VerifiedFileSystemResource $testFileLocation ) {
        $internalBasePathCalculator = new InternalBasePathCalculator( self::PROJECT_REGEX );

        return $internalBasePathCalculator->calculateBasePath( $testFileLocation );
    }


    /**
     * @param \Skelgen\Project\GenericProjectConfig $projectConfig
     *
     * @return array|\Skelgen\Test\TestConfigRenderer[]
     */
    private function getTestConfigRenderers( GenericProjectConfig $projectConfig ) {
        return array(
            new InternalTestConfigRenderer( $projectConfig )
        );
    }


    /**
     * @inheritdoc
     */
    public function getAutoLoaderPath( VerifiedFileSystemResource $testFileLocation ) {
        return null;
    }


    /**
     * @inheritdoc
     */
    public function hasAutoLoader() {
        return false;
    }
}
