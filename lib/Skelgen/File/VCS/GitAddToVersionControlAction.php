<?php

namespace Skelgen\File\VCS;


use Skelgen\File\ExistingDirectory;
use Skelgen\File\ExistingFile;
use Skelgen\File\VerifiedFileSystemResource;

class GitAddToVersionControlAction implements AddToVersionControlAction {
    const CLASS_NAME = __CLASS__;


    /**
     * @param ExistingDirectory $directory
     *
     * @return void
     */
    public function addFolderToVersionControl( ExistingDirectory $directory ) {
        $this->runAddAction( $directory );
    }


    /**
     * @param \Skelgen\File\VerifiedFileSystemResource|\SplFileInfo $path
     */
    public function runAddAction( VerifiedFileSystemResource $path ) {
        $originalDir = getcwd();
        if( $path->isDir() ){
            $directory = $path->getRealPath();
        }else{
            $directory = $path->getPath();
        }

        chdir( $directory );

        $command = 'git add -A "' . $path->getRealPath() . '"';
        echo "Running $command\n";
        $fp      = popen( $command, 'r' );
        while ( !feof( $fp ) ) {
            print fread( $fp, 1024 ) . "\n";
        }

        chdir( $originalDir );
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
