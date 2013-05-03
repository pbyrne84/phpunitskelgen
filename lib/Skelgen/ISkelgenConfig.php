<?php
namespace Skelgen;

use JESkelgen\Config\ItjbSkelgenConfig ;
use JESkelgen\Config\ProjectConfig;
use Skelgen\File\ExistingFile;

interface ISkelgenConfig {


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


    /**
     * @param $filePath
     * @return boolean
     */
    public function isProject( $filePath );
}
