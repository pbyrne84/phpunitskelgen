<?php
namespace Skelgen;

use Skelgen\File\ExistingFile;
use Skelgen\Project\IProjectConfig;

interface ISkelgenConfig {


    /**
     * @param ExistingFile $filePath
     * @return boolean
     */
    public function isProject( ExistingFile $filePath );


    /**
     * @param \ReflectionClass $classToTest
     * @return IProjectConfig
     */
    public function createProjectConfig( \ReflectionClass $classToTest );


    /**
     * @return string
     */
    public function getProjectPathRegex();


    /**
     * @param \Skelgen\File\ExistingFile $testFileLocation
     * @return \Skelgen\File\ExistingFile  - path to an includable file that registers the autoloader
     */
    public function getAutoLoaderPath( ExistingFile $testFileLocation );


    /**
     * @return boolean
     */
    public function hasAutoLoader();


    /**
     * @param \Skelgen\File\ExistingFile $testFileLocation
     * @return \Skelgen\File\ExistingDirectory
     */
    public function getBaseFolder( ExistingFile $testFileLocation );
}
