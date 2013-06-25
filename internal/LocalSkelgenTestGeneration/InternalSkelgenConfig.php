<?php

namespace LocalSkelgenTestGeneration;


use JESkelgen\Calculator\OutputDetailsFactoryParameters;
use Skelgen\File\TestFilePathCalculator;
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
        return false !== strpos( $this->normalisePath( $verifiedFileSystemResource ), '/phpunitskelgen/' );
    }


    /**
     * @param VerifiedFileSystemResource $verifiedFileSystemResource
     *
     * @return string
     */
    private function normalisePath( VerifiedFileSystemResource $verifiedFileSystemResource ) {
        return str_replace( '\\', '/', $verifiedFileSystemResource );
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

        $projectConfig->setCustomRuleMatchers( $this->getCustomRuleMatchers( $projectConfig ) );

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

        $outputDetailsFactoryParameters = new OutputDetailsFactoryParameters(
            $classToTest,
            new ExistingDirectory( $baseProjectFolder ),
            new ExistingDirectory( $baseProjectFolder . '/test/' )
        );

        $testFilePathCalculator = new TestFilePathCalculator( $outputDetailsFactoryParameters );

        return $testFilePathCalculator->calculate( $classToTest );
    }


    /**
     * @param VerifiedFileSystemResource $testFileLocation
     *
     * @return \Skelgen\File\ExistingDirectory
     */
    private function getBaseFolder( VerifiedFileSystemResource $testFileLocation ) {
        return $this
                ->createBasePathCalculator()
                ->calculateBasePath( $testFileLocation );
    }


    /**
     * @return \Skelgen\Project\BasePathCalculator
     */
    private function createBasePathCalculator() {
        return new InternalBasePathCalculator( self::PROJECT_REGEX );
    }


    /**
     * @param \Skelgen\Project\GenericProjectConfig $config
     *
     * @return array|\Skelgen\Test\TestConfigRenderer[]
     */
    private function getCustomRuleMatchers( GenericProjectConfig $config ) {
        return array(
            new InternalTestConfigRenderer( $config )
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
