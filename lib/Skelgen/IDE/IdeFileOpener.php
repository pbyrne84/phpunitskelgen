<?php

namespace Skelgen\IDE;


interface IdeFileOpener {
    /**
     * @param \SplFileInfo $filePath
     *
     * @throws \InvalidArgumentException
     */
    public function openFile( \SplFileInfo $filePath );
}
