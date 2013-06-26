<?php

namespace Skelgen\File\VCS;
use Skelgen\File\ExistingFile;
use Skelgen\File\ExistingDirectory;


/**
 * Class AddToVersionControlAction
 * @package Skelgen\File
 *
 * There is a Null implementation of this to reduce null checks and to disable this functionality.
 */
interface AddToVersionControlAction {
    /**
     * Interfaces, unlike classes in inheritance have to have unique class constant names. :class in 5.5 should
     * solve this.
     * */
    const INTERFACE_NAME_AddToVersionControlAction = __CLASS__;

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
