<?php

namespace Skelgen\File;


class SubversionAddToVersionControlAction implements AddToVersionControlAction {
    const CLASS_NAME = __CLASS__;


    /**
     * @param ExistingDirectory $directory
     */
    public function addFolderToVersionControl( ExistingDirectory $directory ) {
        $this->runAddAction( $directory );
    }


    /**
     * @param \SplFileInfo      $path
     */
    public function runAddAction( \SplFileInfo  $path ) {
        $command = 'svn add "' . $path->getRealPath() . '"';
        $fp      = popen( $command, 'r' );
        while ( !feof( $fp ) ) {
            print fread( $fp, 1024 ) . "\n";
        }
    }


    /**
     * @param ExistingFile $file
     *
     * @return void
     */
    public function addFileToVersionControl( ExistingFile $file ) {
        $this->runAddAction( $file );
    }
}
