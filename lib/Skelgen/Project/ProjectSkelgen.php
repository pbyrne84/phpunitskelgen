<?php
namespace Skelgen\Project;

class ProjectSkelgen {

    const CLASS_NAME = __CLASS__;

    /**
     * @var IProjectConfig
     */
    private $config;


    /**
     * @param IProjectConfig $config
     */
    function __construct( IProjectConfig $config ) {
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
