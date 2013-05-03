<?php
namespace Skelgen\Project;

use Skelgen\File\ExistingDirectory;
use Skelgen\Test\TestConfigRenderer;

interface IProjectConfig {
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
    public function getCustomRuleMatchers();


    /**
     * @return string
     */
    public function getProjectPathRegex();


}
