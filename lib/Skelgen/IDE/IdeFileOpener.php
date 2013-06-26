<?php

namespace Skelgen\IDE;


/**
 * Class IdeFileOpener
 * @package Skelgen\IDE
 *
 * Opens the file in an ide at the end of execution, there is a Null implementation of this to disable this functionality
 * as it is not a required action to generate a test.
 */
interface IdeFileOpener {

    const INTERFACE_IdeFileOpener = __CLASS__;


    /**
     * @param \SplFileInfo $filePath
     *
     * @throws \InvalidArgumentException
     */
    public function openFile( \SplFileInfo $filePath );
}
