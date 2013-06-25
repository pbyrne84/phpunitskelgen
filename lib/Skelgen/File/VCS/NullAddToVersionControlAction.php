<?php

namespace Skelgen\File\VCS;


use Skelgen\File\ExistingDirectory;
use Skelgen\File\ExistingFile;
use Skelgen\File\VCS\AddToVersionControlAction;

class NullAddToVersionControlAction implements AddToVersionControlAction {
    const CLASS_NAME = __CLASS__;


    /**
     * @param ExistingDirectory $directory
     *
     * @return void
     */
    public function addFolderToVersionControl( ExistingDirectory $directory ) {
    }


    /**
     * @param ExistingFile $file
     *
     * @return void
     */
    public function addFileToVersionControl( ExistingFile $file ) {
    }
}
