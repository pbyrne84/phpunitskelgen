<?php
namespace Skelgen\Project;

class ProjectSkelgen {

    const CLASS_NAME = __CLASS__;

    /**
     * @var ProjectConfig
     */
    private $config;


    /**
     * @param ProjectConfig $config
     */
    function __construct( ProjectConfig $config ) {
        $this->config = $config;
    }


    /**
     * @param \JE\IO\ExistingFile $classToMock
     * @return bool
     */
    public function isProject( \JE\IO\ExistingFile $classToMock ) {
        return ( strpos( $classToMock->getPathname(), $this->config->getBaseFolder()->getPathname() ) )=== 0;
    }


    /**
     * @param \JE\IO\ExistingFile $classToMock
     */
    public function generateTestConfig( \JE\IO\ExistingFile $classToMock ) {
        $this->config->getCustomRuleMatchers();
    }

}
