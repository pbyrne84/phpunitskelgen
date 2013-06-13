<?php
namespace Skelgen;

use Skelgen\File\ExistingFile;
use Skelgen\File\VerifiedFileSystemResourceMarker;
use Skelgen\Project\ProjectConfig;

interface ISkelgenConfig {


    /**
     * @param File\VerifiedFileSystemResourceMarker $verifiedFileSystemResource
     *
     * @return boolean
     */
    public function isProject( VerifiedFileSystemResourceMarker $verifiedFileSystemResource );


    /**
     * @param \ReflectionClass $classToTest
     *
     * @return ProjectConfig
     */
    public function createProjectConfig( \ReflectionClass $classToTest );


    /**
     * @return string
     */
    public function getProjectPathRegex();


    /**
     * @param File\VerifiedFileSystemResourceMarker $testFileLocation
     *
     * @return \Skelgen\File\ExistingFile  - path to an includable file that registers the autoloader
     */
    public function getAutoLoaderPath( VerifiedFileSystemResourceMarker $testFileLocation );


    /**
     * @return boolean
     */
    public function hasAutoLoader();


    /**
     *
     * @param File\VerifiedFileSystemResourceMarker $testFileLocation
     *
     * @return \Skelgen\File\ExistingDirectory
     */
    public function getBaseFolder( VerifiedFileSystemResourceMarker $testFileLocation );
}
