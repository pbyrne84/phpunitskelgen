<?php

namespace LocalSkelgenTestGeneration;


use JESkelgen\Calculator\OutputDetailsFactoryParameters;
use Skelgen\File\TestFilePathCalculator;
use JESkelgen\Config\JeProjectConfig;
use Skelgen\Config\SkelgenConfig;
use Skelgen\File\ExistingDirectory;
use Skelgen\File\ExistingFile;
use Skelgen\File\VerifiedFileSystemResource;
use Skelgen\File;
use Skelgen\Project\ProjectConfig;

class InternalSkelgenConfig implements SkelgenConfig {
    const CLASS_NAME = __CLASS__;

    const PROJECT_REGEX = '~(.*/phpunitskelgen/)~i' ;


    /**
     * Used to determine whether the passed in resource matches this project, usually a list of SkelgenConfigs is iterated through
     * until true is returned and then that SkelgenConfig is used for test generation.
     *
     * @param File\VerifiedFileSystemResource $verifiedFileSystemResource
     *
     * @return boolean
     */
    public function isProject( VerifiedFileSystemResource $verifiedFileSystemResource ) {
        return false !== strpos( $this->normalisePath( $verifiedFileSystemResource ), '/phpunitskelgen/lib/' );
    }


    private function normalisePath( VerifiedFileSystemResource $verifiedFileSystemResource ) {
        return str_replace( '\\', '/', $verifiedFileSystemResource );
    }


    /**
     * @param \ReflectionClass $classToTest
     *
     * @return JeProjectConfig|ProjectConfig
     */
    public function createProjectConfig( \ReflectionClass $classToTest ) {
        $projectConfig = new JeProjectConfig(
            $this->getTestOutputFilePath( $classToTest ),
            $this->getBaseFolder( new ExistingFile( $classToTest->getFileName() ) ),
            self::PROJECT_REGEX
        );

        $projectConfig->setCustomRuleMatchers( $this->getCustomRuleMatchers( $projectConfig ) );

        return $projectConfig;
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
        return new \JESkelgen\BasePath\BasePathCalculatorImpl( self::PROJECT_REGEX );
    }



    /**
     * @param \ReflectionClass $classToTest
     *
     * @return string
     */
    private function getTestOutputFilePath( \ReflectionClass $classToTest ) {
        $baseProjectFolder              = $this
                ->getBaseFolder( new ExistingFile( $classToTest->getFileName() ) )
                ->getRealPath();
        $outputDetailsFactoryParameters = new OutputDetailsFactoryParameters(
            $classToTest ,
            new ExistingDirectory( $baseProjectFolder ),
            new ExistingDirectory( $baseProjectFolder . '/test/' )
        );

        $testFilePathCalculator = new TestFilePathCalculator( $outputDetailsFactoryParameters );
        return $testFilePathCalculator->calculate( $classToTest );
    }


    /**
     * @param JeProjectConfig $config
     *
     * @return array|\Skelgen\Test\TestConfigRenderer[]
     */
    private function getCustomRuleMatchers( JeProjectConfig $config ) {
        return array(
            new \JESkelgen\Renderer\ItjbTestConfigRenderer( $config ),
            new \JESkelgen\Renderer\StandardTestConfigRenderer( $config )
        );
    }

    /**
     * Returns the regex used to determine the project path when matching with the isProject call
     *
     * @return string
     */
    public function getProjectPathRegex() {
    }


    /**
     * The custom auto loader path if there is one. Some projects do not follow sane organisational rules so this allows
     * hooking in custom include paths for generation and loading..
     *
     * @param File\VerifiedFileSystemResource $testFileLocation
     *
     * @return \Skelgen\File\ExistingFile  - path to an php include that registers the autoloader
     */
    public function getAutoLoaderPath( VerifiedFileSystemResource $testFileLocation ) {
        return null;
    }


    /**
     * Uses the default one
     * Whether there is a custom auto loader
     * @return boolean
     */
    public function hasAutoLoader() {
        return false;
    }
}
