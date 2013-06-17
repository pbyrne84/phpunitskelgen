<?php
namespace Skelgen;

use Skelgen\File\ExistingFile;
use Skelgen\File\VerifiedFileSystemResourceMarker;
use Skelgen\Project\ProjectConfig;

interface SkelgenConfig {


    /**
     * Used to determine whether the passed in resource matches this project, usually a list of this is iterated through
     * until true is returned and then that instance is returned.
     *
     * @param File\VerifiedFileSystemResourceMarker $verifiedFileSystemResource
     *
     * @return boolean
     */
    public function isProject( VerifiedFileSystemResourceMarker $verifiedFileSystemResource );


    /**
     * Creates an instance of the Project config utilising the reflection class
     *
     * @param \ReflectionClass $classToTest
     *
     * @return ProjectConfig
     */
    public function createProjectConfig( \ReflectionClass $classToTest );


    /**
     * Returns the regex used to determine the project path when matching with the isProject call
     *
     * @return string
     */
    public function getProjectPathRegex();


    /**
     * The custom auto loader path if there is one. Some projects do not follow sane organisational rules so this allows
     * hooking in custom include paths etc for generation and loading..
     *
     * @param File\VerifiedFileSystemResourceMarker $testFileLocation
     *
     * @return \Skelgen\File\ExistingFile  - path to an php include that registers the autoloader
     */
    public function getAutoLoaderPath( VerifiedFileSystemResourceMarker $testFileLocation );


    /**
     * Whether there is a custom auto loader
     * @return boolean
     */
    public function hasAutoLoader();

}
