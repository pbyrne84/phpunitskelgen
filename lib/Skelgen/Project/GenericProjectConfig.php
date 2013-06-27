<?php
namespace Skelgen\Project;

use Skelgen\File\ExistingDirectory;
use Skelgen\Project\ProjectConfig;
use Skelgen\Test\TestConfigRenderer;

class GenericProjectConfig implements ProjectConfig {
    const CLASS_NAME = __CLASS__;

    /**
     * @var string
     */
    private $testOutputFilePath;

    /**
     * @var \Skelgen\File\ExistingDirectory
     */
    private $baseFolder;

    /**
     * @var array|TestConfigRenderer[]
     */
    private $testConfigRenderers;

    /**
     * @var string
     */
    private $projectPathRegex;

    /** @var string */
    private $referenceName;


    /**
     * @param string                          $referenceName
     * @param string                          $testOutputFilePath
     * @param \Skelgen\File\ExistingDirectory $baseFolder
     * @param string                          $projectPathRegex
     */
    function __construct( $referenceName, $testOutputFilePath, ExistingDirectory $baseFolder, $projectPathRegex ) {
        $this->referenceName      = $referenceName;
        $this->testOutputFilePath = $testOutputFilePath;
        $this->baseFolder         = $baseFolder;
        $this->projectPathRegex   = $projectPathRegex;
    }


    /**
     * @return string
     */
    public function getReferenceName() {
        return $this->referenceName;
    }


    /**
     * @param array|TestConfigRenderer[] $testConfigRenderers
     */
    public function setTestConfigRenderers( array $testConfigRenderers ) {
        $this->testConfigRenderers = $testConfigRenderers;
    }


    /**
     * @return string
     */
    public function getTestOutputFilePath() {
        return $this->testOutputFilePath;
    }


    /**
     * @return \Skelgen\File\ExistingDirectory
     */
    public function getBaseFolder() {
        return $this->baseFolder;
    }


    /**
     * @return array|TestConfigRenderer[]
     */
    public function getTestConfigRenderers() {
        return $this->testConfigRenderers;
    }


    /**
     * @return string
     */
    public function getProjectPathRegex() {
        return $this->projectPathRegex;
    }
}
