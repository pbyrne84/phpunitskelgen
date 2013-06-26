<?php

namespace LocalSkelgenTestGeneration;

use Skelgen\Environment\InitialisationConfig;
use Skelgen\File\FileSystem;
use Skelgen\File\SubFolderGenerator;
use Skelgen\File\VCS\GitAddToVersionControlAction;
use Skelgen\PhpStorm\PhpStormFileOpener;
use Skelgen\Config\SkelgenConfig;
use Skelgen\Reflection\CustomReflectionClass;
use Skelgen\Renderer\DomXslTransformer;
use Skelgen\Renderer\XslTransformTestCodeRenderer;
use Skelgen\TestCase\TestCaseWriter;

/**
 * Wrapper class JESkelgenRunner to house the actions needed for our local projects
 *
 * Runs a skelgen comprising of
 * 1. Uses xslt to to do the creation of the test case stub
 * 2. Adds to git
 * 3. Opens the file at the end in PHPStorm
 */
class InternalSkelgenRunner {
    const CLASS_NAME = __CLASS__;


    /**
     * @param InitialisationConfig $initialisationConfig
     * @param \Skelgen\Config\SkelgenConfig        $skelgenConfig
     */
    public function runSkelgen( InitialisationConfig $initialisationConfig, SkelgenConfig $skelgenConfig ){
        $customReflectionClass     = new CustomReflectionClass( $initialisationConfig->getClassName() );
        $addToVersionControlAction = new GitAddToVersionControlAction();
        $testCaseWriter            = new TestCaseWriter(
            new PhpStormFileOpener(),
            new XslTransformTestCodeRenderer( new DomXslTransformer() ),
            new SubFolderGenerator( new FileSystem(), $addToVersionControlAction ),
            $addToVersionControlAction
        );

        $projectConfig = $skelgenConfig->createProjectConfig( $customReflectionClass );
        $testCaseWriter->writeTestCase( $projectConfig, $customReflectionClass );
    }
}
