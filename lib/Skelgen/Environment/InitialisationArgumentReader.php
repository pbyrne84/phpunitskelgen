<?php

namespace Skelgen\Environment;


use Skelgen\File\ExistingFile;

class InitialisationArgumentReader {
    const CLASS_NAME = __CLASS__;


    /**
     * @return InitialisationConfig
     */
    public function readInitialisation() {
        $sourceFileLocation = $_SERVER[ 'argv' ][ 4 ];
        $className          = $_SERVER[ 'argv' ][ 3 ];
        $sourceFileLocation = str_replace( '\\', '/', $sourceFileLocation );
        $projectFile        = new ExistingFile( $sourceFileLocation );

        return new InitialisationConfig( $className, $projectFile );

    }
}
