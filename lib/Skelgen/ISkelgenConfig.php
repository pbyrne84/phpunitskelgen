<?php
namespace Skelgen;

use Skelgen\File\ExistingFile;
use Skelgen\Project\ProjectConfig;

interface ISkelgenConfig {


    /**
     * @param \SplFileInfo $resourcePath
     *
     * @return boolean
     */
    public function isProject( \SplFileInfo $resourcePath );


    /**
     * @param \ReflectionClass $classToTest
     * @return ProjectConfig
     */
    public function createProjectConfig( \ReflectionClass $classToTest );


    /**
     * @return string
     */
    public function getProjectPathRegex();


    /**
     * @param \SplFileInfo $testFileLocation
     *
     * @return \Skelgen\File\ExistingFile  - path to an includable file that registers the autoloader
     */
    public function getAutoLoaderPath( \SplFileInfo $testFileLocation );


    /**
     * @return boolean
     */
    public function hasAutoLoader();


    /**
     * @param \Skelgen\File\ExistingFile|\SplFileInfo $testFileLocation
     *
     * @return \Skelgen\File\ExistingDirectory
     */
    public function getBaseFolder( \SplFileInfo $testFileLocation );
}
