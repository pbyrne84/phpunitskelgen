<?php

namespace Skelgen\Environment;


use Skelgen\File\ExistingFile;

class InitialisationConfig {
    const CLASS_NAME = __CLASS__;

    /** @var string */
    private $className;

    /** @var \Skelgen\File\ExistingFile */
    private $sourceFile;


    /**
     * @param string       $className
     * @param ExistingFile $sourceFile
     */
    function __construct( $className, ExistingFile $sourceFile ) {
        $this->className  = $className;
        $this->sourceFile = $sourceFile;
    }


    /**
     * @return string
     */
    public function getClassName() {
        return $this->className;
    }


    /**
     * @return \Skelgen\File\ExistingFile
     */
    public function getSourceFile() {
        return $this->sourceFile;
    }


}
