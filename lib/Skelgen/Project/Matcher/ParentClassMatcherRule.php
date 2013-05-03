<?php
namespace Skelgen\Project\Matcher;

class ParentClassMatcherRule {
    const CLASS_NAME = __CLASS__;
    /**
     * @var \JE\IO\ExistingFile
     */
    private $template;

    /**
     * @var \Skelgen\Test\TestConfigFactory
     */
    private $testConfigFactory;

    /**
     * @var \Skelgen\File\ExistingDirectory
     */
    private $testOutputFilePath;

    /**
     * @var string
     */
    private $parentClassName;


    /**
     * @param \Skelgen\Test\TestConfigFactory  $testConfigFactory
     * @param \Skelgen\File\ExistingFile       $template
     * @param                                  $testOutputFilePath
     * @param string                           $parentClassName
     */
    function __construct( \Skelgen\Test\TestConfigFactory $testConfigFactory,
                          \Skelgen\File\ExistingFile $template,
                          $testOutputFilePath,
                          $parentClassName ) {
        $this->testConfigFactory  = $testConfigFactory;
        $this->template           = $template;
        $this->testOutputFilePath = $testOutputFilePath;
        $this->parentClassName    = $parentClassName;
    }


    /**
     * @param \Skelgen\Reflection\CustomReflectionClass $reflectionClass
     * @return null|\Skelgen\Test\TestConfig
     */
    public function attemptMatch( \Skelgen\Reflection\CustomReflectionClass $reflectionClass ) {
        if( !$reflectionClass->getName() == $reflectionClass ) {
            return null;
        }

        return $this->testConfigFactory->createTestConfigFactory(
            $this->template, $this->testOutputFilePath, $reflectionClass
        );
    }
}
