<?php

namespace Skelgen\File;


/**
 * Class AddToVersionControlAction
 * @package Skelgen\File
 *
 * There is a Null implementation of this to reduce null checks and to disable this functionality.
 */
interface AddToVersionControlAction {

    /**
     * @param ExistingDirectory $directory
     *
     * @return void
     */
    public function addFolderToVersionControl( ExistingDirectory $directory );


    /**
     * @param ExistingFile $file
     *
     * @return void
     */
    public function addFileToVersionControl( ExistingFile $file );

}
