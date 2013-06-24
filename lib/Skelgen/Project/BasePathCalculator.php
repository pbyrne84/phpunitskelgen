<?php
namespace Skelgen\Project;

interface BasePathCalculator {

    /**
     * @param \Skelgen\File\VerifiedFileSystemResource $classFilePath
     *
     * @return \Skelgen\File\ExistingDirectory - basePath
     */
    public function calculateBasePath( \Skelgen\File\VerifiedFileSystemResource $classFilePath );
}
