<?php

namespace Skelgen\File;


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
