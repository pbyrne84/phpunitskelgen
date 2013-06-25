<?php
namespace Skelgen\Config;

use Skelgen\File\ExistingFile;
use Skelgen\File\VerifiedFileSystemResource;
use Skelgen\File;
use Skelgen\Project\ProjectConfig;

interface SkelgenConfig {

    /**
     * @return string - project reference name for config
     */
    public function getProjectName();


    /**
     * Used to determine whether the passed in resource matches this project, usually a list of SkelgenConfigs is iterated through
     * until true is returned and then that SkelgenConfig is used for test generation.
     *
     * @param File\VerifiedFileSystemResource $verifiedFileSystemResource
     *
     * @return boolean
     */
    public function isProject( VerifiedFileSystemResource $verifiedFileSystemResource );


    /**
     * Creates an instance of the Project config utilising the reflection class
     *
     * @param \ReflectionClass $classToTest
     *
     * @return ProjectConfig
     */
    public function createProjectConfig( \ReflectionClass $classToTest );


    /**
     * The custom auto loader path if there is one. Some projects do not follow sane organisational rules so this allows
     * hooking in custom include paths for generation and loading..
     *
     * @param File\VerifiedFileSystemResource $testFileLocation
     *
     * @return \Skelgen\File\ExistingFile  - path to an php include that registers the autoloader
     */
    public function getAutoLoaderPath( VerifiedFileSystemResource $testFileLocation );


    /**
     * Whether there is a custom auto loader
     * @return boolean
     */
    public function hasAutoLoader();

}
