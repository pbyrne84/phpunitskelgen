<?php
namespace Skelgen\Project;

interface BasePathCalculator {

    /**
     * @param \Skelgen\File\VerifiedFileSystemResourceMarker $classFilePath
     *
     * @return \Skelgen\File\ExistingDirectory - basePath
     */
    public function calculateBasePath( \Skelgen\File\VerifiedFileSystemResourceMarker $classFilePath );
}
