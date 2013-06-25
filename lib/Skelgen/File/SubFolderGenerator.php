<?php

namespace Skelgen\File;


use Skelgen\File\VCS\AddToVersionControlAction;
use Skelgen\File\VCS\NullAddToVersionControlAction;

class SubFolderGenerator {
    const CLASS_NAME = __CLASS__;

    /** @var AddToVersionControlAction */
    private $addToVersionControlAction;


    /**
     * @param AddToVersionControlAction $addToVersionControlAction
     */
    function __construct( AddToVersionControlAction $addToVersionControlAction = null ) {
        if ( $addToVersionControlAction === null ) {
            $this->addToVersionControlAction = new NullAddToVersionControlAction();

            return;
        }

        $this->addToVersionControlAction = $addToVersionControlAction;
    }


    /**
     * Generates the any sub folders required adding them to version control if and active implementation of
     * AddToVersionControlAction has been injected in the constructor.
     *
     * @param string $testFilePath
     */
    public function generateRequiredSubFolders( $testFilePath ) {
        $testFilePath = str_replace( '\\', '/', $testFilePath );
        $folderParts  = explode( '/', $testFilePath );
        unset( $folderParts[ count( $folderParts ) - 1 ] );
        $currentDir = '';
        foreach ( $folderParts as $folderPart ) {
            $currentDir .= $folderPart . '/';
            var_dump( $currentDir );
            if ( !is_dir( $currentDir ) ) {
                mkdir( $currentDir );
                $this->addToVersionControlAction->addFolderToVersionControl( new ExistingDirectory( $currentDir ) );
            }
        }
    }
}
