<?php
namespace Skelgen\Project;

use Skelgen\File\ExistingDirectory;
use Skelgen\Test\TestConfigRenderer;

interface ProjectConfig {

    /**
     * @return string
     */
    public function getReferenceName();

    /**
     * @return string
     */
    public function getTestOutputFilePath();


    /**
     * @return \Skelgen\File\ExistingDirectory
     */
    public function getBaseFolder();



    /**
     * @return array|TestConfigRenderer[]
     */
    public function getTestConfigRenderers();


    /**
     * @return string
     */
    public function getProjectPathRegex();


}
