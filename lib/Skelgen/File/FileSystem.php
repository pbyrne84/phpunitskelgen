<?php

namespace Skelgen\File;


class FileSystem {
    const CLASS_NAME = __CLASS__;


    public function isDir( $path ) {
        return is_dir( $path );
    }


    public function mkDir( $path ) {
        if ( !mkdir( $path ) ) {
            throw new DirectoryCreationException( 'Could not create ' . $path );
        };
    }


    /**
     * @param $path
     *
     * @return ExistingDirectory
     */
    public function getDirectory( $path ) {
        return new ExistingDirectory( $path );
    }


    /**
     * @param $path
     *
     * @return ExistingDirectory
     */
    public function getFile( $path ) {
        return new ExistingFile( $path );
    }


}
