<?php

namespace Skelgen\File;


class SubversionAddToVersionControlAction implements AddToVersionControlAction {
    const CLASS_NAME = __CLASS__;


    public function addToVersionControl( ExistingDirectory $directory ) {
        $command = 'svn add "' . $directory->getRealPath() . '"';
        $fp = popen( $command, 'r' );
        while(!feof($fp))  {
            print fread($fp, 1024) . "\n";
        }
    }
}
