<?php

namespace Skelgen\File;


use Skelgen\File\VCS\AddToVersionControlAction;
use Skelgen\File\VCS\NullAddToVersionControlAction;

class SubFolderGenerator {
    const CLASS_NAME = __CLASS__;

    /** @var AddToVersionControlAction */
    private $addToVersionControlAction;

    /** @var FileSystem */
    private $fileSystem;


    /**
     * @param FileSystem                $fileSystem
     * @param AddToVersionControlAction $addToVersionControlAction
     */
    function __construct( FileSystem $fileSystem, AddToVersionControlAction $addToVersionControlAction ) {
        $this->fileSystem                = $fileSystem;
        $this->addToVersionControlAction = $addToVersionControlAction;
    }


    /**
     * Generates the any sub folders required adding them to version control if and active implementation of
     * AddToVersionControlAction has been injected in the constructor.
     *
     * @param string $testFilePath
     */
    public function generateRequiredSubFolders( $testFilePath ) {
        $subFolderParts = $this->createSubFolderParts( $testFilePath );

        $currentDir = '';
        foreach ( $subFolderParts as $possibleNewSubFolder ) {
            $currentDir .= $possibleNewSubFolder . '/';
            if ( !$this->fileSystem->isDir( $currentDir ) ) {
                $this->initialiseNewSubDirectory( $currentDir );
            }
        }
    }


    /**
     * @param string $testFilePath
     *
     * @return array
     */
    private function createSubFolderParts( $testFilePath ) {
        $testFilePath = str_replace( '\\', '/', $testFilePath );
        $folderParts  = explode( '/', $testFilePath );
        unset( $folderParts[ count( $folderParts ) - 1 ] );

        return $folderParts;
    }


    /**
     * @param string $currentDir
     */
    private function initialiseNewSubDirectory( $currentDir ) {
        $this->fileSystem->mkDir( $currentDir );
        $createdDirectory = $this->fileSystem->getDirectory( $currentDir );
        $this->addToVersionControlAction->addFolderToVersionControl( $createdDirectory );
    }
}
