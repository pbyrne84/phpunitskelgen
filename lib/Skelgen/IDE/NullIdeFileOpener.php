<?php

namespace Skelgen\IDE;


class NullIdeFileOpener implements IdeFileOpener {
    const CLASS_NAME = __CLASS__;


    /**
     * @param \SplFileInfo $filePath
     *
     * @throws \InvalidArgumentException
     */
    public function openFile( \SplFileInfo $filePath ) {
    }
}
