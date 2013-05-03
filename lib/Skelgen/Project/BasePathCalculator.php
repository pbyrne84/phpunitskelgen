<?php
namespace Skelgen\Project;

interface BasePathCalculator {

    /**
     * @param \Skelgen\File\ExistingFile $classFilePath
     * @return \Skelgen\File\ExistingDirectory - basePath
     */
    public function calculateBasePath( \Skelgen\File\ExistingFile $classFilePath );
}
