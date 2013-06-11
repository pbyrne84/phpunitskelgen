<?php

namespace Skelgen\File;


class SubFolderGenerator {
    const CLASS_NAME = __CLASS__;

    /** @var AddToVersionControlAction */
    private $addToVersionControlAction;


    function __construct( AddToVersionControlAction $addToVersionControlAction = null ) {
        if( $addToVersionControlAction === null ){
            $this->addToVersionControlAction = new NullAddToVersionControlAction();
            return;
        }

        $this->addToVersionControlAction = $addToVersionControlAction;
    }


    public function generateRequiredSubfolders( $testFilePath ) {
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
