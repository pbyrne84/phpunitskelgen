<?php
namespace LocalSkelgenTestGeneration;

use Skelgen\File\ExistingDirectory;
use Skelgen\Project\BasePathCalculator;

class InternalBasePathCalculator implements BasePathCalculator {
    const CLASS_NAME = __CLASS__;

    private $regex;


    function __construct( $regex ) {
        $this->regex = $regex;
    }


    /**
     *
     * @param \Skelgen\File\VerifiedFileSystemResource $classFilePath
     *
     * @throws \RuntimeException
     * @return \Skelgen\File\ExistingDirectory - basePath
     */
    public function calculateBasePath( \Skelgen\File\VerifiedFileSystemResource $classFilePath ) {
        $absolutePath = $classFilePath->getNormalisedRealPath();
        if ( !preg_match( $this->regex, $absolutePath, $matches ) ) {
            throw new \RuntimeException( "cannot calculate base path using '" . $this->regex . "' in " . $absolutePath );
        }

        return new ExistingDirectory( $matches[ 0 ] );
    }
}
